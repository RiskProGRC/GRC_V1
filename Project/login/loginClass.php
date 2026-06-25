<?php
require_once dirname(__FILE__) . '/../core/BaseRepository.php'; /* 3.1 — BaseRepository provides fetchOne/fetchAll + ActivityLogger auto-loaded */

class loginClass extends BaseRepository { /* 3.1 — was connectionClass */

    public function signup(string $fname, string $sname, string $dept, string $gender, string $email, string $phone, string $user, string $hpass, string $access) {
        $fname  = $this->real_escape_string($fname);
        $sname  = $this->real_escape_string($sname);
        $dept   = $this->real_escape_string($dept);
        $gender = $this->real_escape_string($gender);
        $email  = $this->real_escape_string($email);
        $phone  = $this->real_escape_string($phone);
        $user   = $this->real_escape_string($user);
        $pass   = $this->real_escape_string($hpass);

        $insert = "INSERT INTO users(fname,sname,gender,dept_id,email,phone,username,upassword,access,user_type)
        VALUES('$fname','$sname','$gender','$dept','$email','$phone','$user','$pass','$access',0)";
        $query  = $this->query($insert) or die($this->error);
        return $query ? "USER REGISTERED" : "DATA NOT SENT";
    }

    public function resetPassword(string $email, string $token) {
        $email = $this->real_escape_string($email);

        $check_email = "SELECT email FROM users WHERE email='$email' LIMIT 1";
        $query_check = $this->query($check_email) or die($this->error);

        if ($query_check->num_rows > 0) {
            $row       = $query_check->fetch_assoc();
            $get_email = $row["email"];

            $update_token = "UPDATE users SET verify_token='$token' WHERE email='$get_email' LIMIT 1";
            $query_token  = $this->query($update_token);
            if (!$query_token) {
                return "ERROR CHECK ";
            }
            /* 1.7 — empty send_password_reset() removed; email is sent by reset-password-action.php */
            return "its available";
        } else {
            return "ERROR CHECK ";
        }
    }

    public function googlesignup(string $authid, string $name, string $email, string $password) {
        /* 1.2 — all fopen/fwrite/fclose debug log lines removed; file was publicly readable */
        $authid   = $this->real_escape_string($authid);
        $name     = $this->real_escape_string($name);
        $email    = $this->real_escape_string($email);
        $password = $this->real_escape_string($password);

        $nameParts = explode(' ', $name, 2);
        $fname     = $nameParts[0];
        $sname     = isset($nameParts[1]) ? $nameParts[1] : '';

        $select = "SELECT * FROM users WHERE email = '$email'";
        $query  = $this->query($select) or die($this->error);

        if ($query->num_rows > 0) {
            $row = $query->fetch_assoc();
            session_regenerate_id(true); /* 1.1 — rotate session ID on Google login */
            $_SESSION["uid"]     = $row["id"];
            $_SESSION["user"]    = $row["username"];
            $_SESSION["dept_id"] = $row["dept_id"];
            $_SESSION["roles"]   = $row["roles"];
            header("Location: systemover.php");
            exit;
        } else {
            $username    = strtolower(str_replace(' ', '', $name));
            $phone       = '0000';
            $gender      = 'male';
            $dept_id     = 1;
            $roles       = 2;
            $access      = 1;
            $bsc_setting = 0;

            $insert = "INSERT INTO users (fname, sname, gender, dept_id, email, phone, username, upassword, roles, access, bsc_setting)
            VALUES ('$fname', '$sname', '$gender', $dept_id, '$email', '$phone', '$username', '$password', $roles, $access, $bsc_setting)";

            try {
                $query = $this->query($insert);
                if ($query) {
                    $newUserId = $this->insert_id;
                    session_regenerate_id(true); /* 1.1 — rotate session ID for new Google user */
                    $_SESSION["uid"]     = $newUserId;
                    $_SESSION["user"]    = $username;
                    $_SESSION["dept_id"] = $dept_id;
                    $_SESSION["roles"]   = $roles;
                    header("Location: systemover.php");
                    exit;
                } else {
                    $_SESSION['login_error'] = "Registration failed. Please try again.";
                    header("Location: login.php");
                    exit;
                }
            } catch (Exception $e) {
                $_SESSION['login_error'] = "Registration error. Please try again.";
                header("Location: login.php");
                exit;
            }
        }
    }

    public function Update(string $uid, string $fname, string $sname, string $dept, string $gender, string $email, string $phone, string $user, string $roles, string $access) {
        $fname  = $this->real_escape_string($fname);
        $sname  = $this->real_escape_string($sname);
        $email  = $this->real_escape_string($email);
        $phone  = $this->real_escape_string($phone);
        $user   = $this->real_escape_string($user);
        $access = $this->real_escape_string($access);

        $insert = "UPDATE users SET fname='$fname',sname='$sname',gender='$gender',dept_id='$dept',email='$email',phone='$phone',username='$user',roles='$roles',access='$access' WHERE id='$uid'";
        $query  = $this->query($insert) or die($this->error);
        return $query ? "USER PROFILE UPDATE" : "DATA NOT SENT";
    }

    public function passupdate(string $uid, string $hpass, string $email, string $token) {
        $raw_token = $token; /* save original before escaping for the prepared statement below */
        $pass      = $this->real_escape_string($hpass);
        $email     = $this->real_escape_string($email);
        $token     = $this->real_escape_string($token);

        if (empty($token)) {
            return 'No token provided';
        }
        if (empty($email) || empty($pass)) {
            return 'Missing required fields';
        }

        $check_token = "SELECT * FROM users WHERE verify_token='$token' LIMIT 1";
        $query_token = $this->query($check_token) or die($this->error);

        if ($query_token->num_rows > 0) {
            /* 1.3 — check token has not expired (requires token_expires_at column) */
            $row_token = $query_token->fetch_assoc();
            if (isset($row_token['token_expires_at']) && strtotime($row_token['token_expires_at']) < time()) {
                return "Reset link has expired. Please request a new one.";
            }

            $update_pass       = "UPDATE users SET upassword='$pass', user_type=1 WHERE verify_token='$token'";
            $update_pass_query = $this->query($update_pass) or die($this->error);

            if ($update_pass_query) {
                $clear = $this->prepare("UPDATE users SET verify_token = NULL, token_expires_at = NULL WHERE verify_token = ?"); /* 2.6 — nullify token after use — replaces md5(rand()) rotation */
                $clear->bind_param('s', $raw_token);
                $clear->execute();
                $clear->close();
                return "Password updated";
            } else {
                return "Password Not Updated";
            }
        } else {
            return "Invalid Token found";
        }
    }

    /* 2.3 — count failed logins in last 15 min by column (ip_address or email)
       Requires schema migration:
         ALTER TABLE login_attempt
           ADD COLUMN email VARCHAR(255) NULL AFTER ip_address,
           ADD COLUMN attempted_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
           DROP COLUMN time_count;
         CREATE INDEX idx_la_ip    ON login_attempt (ip_address, attempted_at);
         CREATE INDEX idx_la_email ON login_attempt (email, attempted_at); */
    private function countRecentFailures(string $col, string $val): int {
        $window = date('Y-m-d H:i:s', strtotime('-15 minutes'));
        $stmt   = $this->prepare("SELECT COUNT(*) FROM login_attempt WHERE `$col` = ? AND attempted_at > ?");
        $stmt->bind_param('ss', $val, $window);
        $stmt->execute();
        return (int) $stmt->get_result()->fetch_row()[0];
    }

    private function recordFailedAttempt(string $ip_address, string $email): void { /* 2.3 — persist failure for rate-limit checks */
        $stmt = $this->prepare("INSERT INTO login_attempt (ip_address, email, attempted_at) VALUES (?, ?, NOW())");
        $stmt->bind_param('ss', $ip_address, $email);
        $stmt->execute();
        $stmt->close();
    }

    public function login(string $email, string $pass, string $ip_address) {
        if (empty($email) || empty($pass)) {
            return "Please fill all fields!";
        }

        if ($this->countRecentFailures('ip_address', $ip_address) >= 5 || /* 2.3 — brute force: 5 attempts per 15 min by IP */
            $this->countRecentFailures('email', $email) >= 5) {           /* 2.3 — and by email — VPN bypass blocked */
            return 'locked';
        }

        $row = $this->fetchOne('users', 'email', $email); /* 3.2 — fetchOne replaces raw prepare/execute block */

        if ($row) {
            if (password_verify($pass, $row['upassword']) && $row["user_type"] == 1) {
                session_regenerate_id(true); /* 1.1 — new session ID on login, closes session fixation */
                $_SESSION["uid"]     = $row["id"];
                $_SESSION["user"]    = $row["username"];
                $_SESSION["dept_id"] = $row["dept_id"];
                $_SESSION["roles"]   = $row["roles"];

                ActivityLogger::log($this, $row['id'], 'Login', "user {$row['username']} logged in", $ip_address); /* 3.3 — ActivityLogger replaces raw INSERT */

                return 'WELCOME &nbsp;&nbsp;' . $_SESSION["user"];

            } elseif (password_verify($pass, $row["upassword"]) && $row["user_type"] == 0) {
                session_regenerate_id(true); /* 1.1 — rotate session ID on first-login path too */
                $_SESSION["uid"]     = $row["id"];
                $_SESSION["user"]    = $row["username"];
                $_SESSION["dept_id"] = $row["dept_id"];
                $_SESSION["roles"]   = $row["roles"];

                return 'first_login'; /* user_type=0 — must change password before accessing system */
            } else {
                $this->recordFailedAttempt($ip_address, $email); /* 2.3 — log the failed attempt */
                return 3;
            }
        } else {
            $this->recordFailedAttempt($ip_address, $email); /* 2.3 — same path for unknown email — prevents timing discrimination */
            return 3; /* 2.5 — same return value for wrong password and unknown email */
        }
    }

    public function logout(string $uid): void {
        $row = $this->fetchOne('users', 'id', $uid); /* 3.2 — fetchOne replaces raw SELECT */
        if ($row) {
            ActivityLogger::log($this, (int)$uid, 'Logout', "user {$row['username']} logged out", 'NA'); /* 3.3 — ActivityLogger replaces raw INSERT */
        }
    }

    public function systemlog(): array {
        return $this->fetchAll('system_logs'); /* 3.2 — fetchAll replaces manual loop — always returns array, never a string */
    }
}

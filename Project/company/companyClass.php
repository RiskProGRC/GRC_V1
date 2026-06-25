<?php
require_once __DIR__ . '/../core/BaseRepository.php';

class companyClass extends BaseRepository {

    // create a new group with logo upload
    public function group(string $uid, string $ipaddress, string $name, string $address, string $logo, string $country, string $website, string $objectives): mixed {
        $targetDir      = "../assets/images/logo/";
        $targetfilepath = $targetDir . $logo;
        $fileType       = pathinfo($targetfilepath, PATHINFO_EXTENSION);
        $allowtypes     = ['jpg', 'png', 'jpeg', 'gif', 'pdf'];

        if (!in_array($fileType, $allowtypes)) {
            return "Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.";
        }
        if (!move_uploaded_file($_FILES["file"]["tmp_name"], $targetfilepath)) {
            return "sorry, there was error uploading file";
        }

        $stmt = $this->prepare(
            "INSERT INTO cgroup(name,address,logo,country,objectives,website) VALUES(?,?,?,?,?,?)"
        );
        $stmt->bind_param('ssssss', $name, $address, $targetfilepath, $country, $objectives, $website);
        $stmt->execute();
        if ($stmt->affected_rows < 1) {
            return "DATA NOT INSERTED";
        }
        ActivityLogger::log($this, $uid, 'Settings', 'created a new Group', $ipaddress);
        return header("Location:bussinf.php");
    }

    // create a new company with logo upload
    public function addCompany(string $uid, string $ipaddress, string $logo, string $name, string $group, string $email, string $phone, string $website, string $address): mixed {
        $targetDir      = "../assets/images/logo/";
        $targetfilepath = $targetDir . $logo;
        $fileType       = pathinfo($targetfilepath, PATHINFO_EXTENSION);
        $allowtypes     = ['jpg', 'png', 'jpeg', 'gif', 'pdf'];

        if (!in_array($fileType, $allowtypes)) {
            return "Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.";
        }
        if (!move_uploaded_file($_FILES["file"]["tmp_name"], $targetfilepath)) {
            return "sorry, there was error uploading file";
        }

        $stmt = $this->prepare(
            "INSERT INTO company(company_name,cgroup,email,phone,website,address,logo) VALUES(?,?,?,?,?,?,?)"
        );
        $stmt->bind_param('sssssss', $name, $group, $email, $phone, $website, $address, $targetfilepath);
        $stmt->execute();
        if ($stmt->affected_rows < 1) {
            return "DATA NOT INSERTED";
        }
        ActivityLogger::log($this, $uid, 'Company', 'added a new company', $ipaddress);
        return header("Location:bussinf.php");
    }

    // return all groups
    public function showgroup(): array {
        return $this->fetchAll('cgroup');
    }

    // return all companies
    public function showCompany(): array {
        return $this->fetchAll('company');
    }

    // return company name for a given id (used in joins)
    public function companyJoins(string $cid): string {
        $row = $this->fetchOne('company', 'id', $cid);
        return $row ? $row['company_name'] : 'NO VALUES FOUND';
    }

    // return full company row for edit form
    public function fetchedit(string $cid): ?array {
        return $this->fetchOne('company', 'id', $cid);
    }

    // update company details
    public function update(string $uid, string $ipaddress, string $companyid, string $cname, string $group, string $email, string $phone, string $website, string $address): string {
        $stmt = $this->prepare(
            "UPDATE company SET company_name=?,cgroup=?,email=?,phone=?,website=?,address=? WHERE id=?"
        );
        $stmt->bind_param('sssssss', $cname, $group, $email, $phone, $website, $address, $companyid);
        $stmt->execute();
        ActivityLogger::log($this, $uid, 'Company', "edited company id= $companyid", $ipaddress);
        return "DATA SUCCESSFULLY UPDATED";
    }

    // delete a company row
    public function delete(string $dcid): string {
        return $this->deleteById('company', 'id', $dcid)
            ? "Record Deleted"
            : "DATA NOT DELETED";
    }
}

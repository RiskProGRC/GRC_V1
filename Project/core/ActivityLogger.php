<?php
class ActivityLogger { // static utility — no instantiation needed, just call ActivityLogger::log()

    // write one audit row to system_logs — replaces the 3-line INSERT block copy-pasted in every entity write method
    public static function log(mysqli $conn, int|string $uid, string $entity, string $action, string $ip): void {
        $stmt = $conn->prepare(    // use the entity class's own connection
            "INSERT INTO `system_logs` (`user_id`, `entity`, `action`, `ip_address`) VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param('ssss', $uid, $entity, $action, $ip); // bind all 4 values as strings
        $stmt->execute(); // write the log row — no return value needed
    }
}

<?php
require_once __DIR__ . '/../connection/connectionClass.php'; // load the DB connection class
require_once __DIR__ . '/ActivityLogger.php';               // audit logger — available to all entity classes automatically

class BaseRepository extends connectionClass { // sits between connectionClass and all entity classes

    // fetch every row from a table — replaces all showX() methods
    protected function fetchAll(string $table): array {
        $stmt = $this->prepare("SELECT * FROM `$table`"); // prepare safe query
        $stmt->execute();                                  // run it
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC) ?? []; // return all rows as array, empty array if none
    }

    // fetch all rows where a column matches a value — replaces showXdept(), showrecommenddept(), etc.
    protected function fetchWhere(string $table, string $col, mixed $val): array {
        $stmt = $this->prepare("SELECT * FROM `$table` WHERE `$col` = ?"); // ? is a safe placeholder
        $stmt->bind_param('s', $val);                                       // bind the value as a string
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC) ?? []; // return matching rows, empty array if none
    }

    // fetch a single row by any column — replaces fetchedit(), editDetails(), fetchById(), etc.
    protected function fetchOne(string $table, string $col, mixed $val): ?array {
        $stmt = $this->prepare("SELECT * FROM `$table` WHERE `$col` = ? LIMIT 1"); // LIMIT 1 — we only want one row
        $stmt->bind_param('s', $val);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc() ?: null; // return the row, or null if not found
    }

    // delete a single row by any column — replaces every delete() method in entity classes
    protected function deleteById(string $table, string $col, mixed $val): bool {
        $stmt = $this->prepare("DELETE FROM `$table` WHERE `$col` = ?");
        $stmt->bind_param('s', $val);
        $stmt->execute();
        return $stmt->affected_rows > 0; // true if a row was actually deleted, false if nothing matched
    }

    // count all rows in a table — replaces dashboard() count methods
    protected function countAll(string $table): int {
        $result = $this->query("SELECT COUNT(*) FROM `$table`"); // no user input so direct query is safe here
        return (int) $result->fetch_row()[0];                   // cast to int and return the count
    }

    // count rows where a column matches a value — replaces filtered count methods
    protected function countWhere(string $table, string $col, mixed $val): int {
        $stmt = $this->prepare("SELECT COUNT(*) FROM `$table` WHERE `$col` = ?");
        $stmt->bind_param('s', $val);
        $stmt->execute();
        return (int) $stmt->get_result()->fetch_row()[0]; // cast to int and return the count
    }
}

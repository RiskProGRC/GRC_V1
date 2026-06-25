<?php
require_once __DIR__ . '/../core/BaseRepository.php';

class riskCatClass extends BaseRepository {

    // insert a new risk category row
    public function addRiskCat(string $uid, string $ipaddress, string $name, string $rcdesc): string {
        $stmt = $this->prepare("INSERT INTO riskcat(name,description) VALUES(?,?)");
        $stmt->bind_param('ss', $name, $rcdesc);
        $stmt->execute();
        if ($stmt->affected_rows < 1) {
            return "DATA NOT ENTERED";
        }
        ActivityLogger::log($this, $uid, 'Risk Category', 'Added risk category', $ipaddress);
        return "Risk Category Added";
    }

    // return all risk category rows
    public function showRiskCat(): array {
        return $this->fetchAll('riskcat');
    }

    // return full riskcat row for edit form
    public function editimpact(string $rcid): ?array {
        return $this->fetchOne('riskcat', 'riskcat_id', $rcid);
    }

    // update an existing risk category row
    public function updateriskcat(string $uid, string $ipaddress, string $rcid, string $name, string $rcdesc): string {
        $stmt = $this->prepare("UPDATE riskcat SET name=?,description=? WHERE riskcat_id=?");
        $stmt->bind_param('sss', $name, $rcdesc, $rcid);
        $stmt->execute();
        ActivityLogger::log($this, $uid, 'Risk Category', "Edited Risk category id=$rcid", $ipaddress);
        return "risk category Updated";
    }

    // delete a risk category row
    public function delete(string $rcid): string {
        return $this->deleteById('riskcat', 'riskcat_id', $rcid)
            ? "risk category Deleted"
            : "DATA NOT DELETED";
    }

    // return risk category name for a given id (used in joins)
    public function riskcatJoins(string $rcatid): string {
        $row = $this->fetchOne('riskcat', 'riskcat_id', $rcatid);
        return $row ? $row['name'] : 'NO VALUES FOUND';
    }
}

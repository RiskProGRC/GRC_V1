<?php
session_start();

function generateTemplate($type) {
    $filename = '';
    $headers = [];
    $sampleData = [];

    switch ($type) {
        case 'risks':
            $filename = 'Risk_Upload_Template.csv';
            $headers = [
                'Risk Name*', 'Risk Category', 'Process', 'Cause*', 'Consequence',
                'Risk Owner', 'Inherent Likelihood', 'Inherent Impact',
                'Existing Controls', 'Residual Likelihood', 'Residual Impact'
            ];
            $sampleData = [
                'Data breach due to system vulnerability',
                'Information Security',
                'IT Operations',
                'Outdated security patches and weak access controls',
                'Loss of confidential data, regulatory fines, reputation damage',
                'IT Manager',
                '3',
                '4',
                'Firewall, antivirus, access controls',
                '2',
                '3'
            ];
            break;
        case 'complete':
            $filename = 'Complete_Risk_Register_Template.csv';
            $headers = [
                'Risk Name*', 'Process', 'Cause*', 'Department', 'Category',
                'Inherent Impact', 'Inherent Likelihood', 'Controls', 'Status'
            ];
            $sampleData = [
                'System failure risk',
                'IT Operations',
                'Hardware malfunction',
                'IT Department',
                'Operational',
                '4',
                '3',
                'Backup systems',
                'Active'
            ];
            break;
        case 'controls':
            $filename = 'Control_Action_Template.csv';
            $headers = [
                'Control Name', 'Action Name*', 'Status', 'Priority', 'Timeline',
                'Owner', 'Control Type', 'Control Strength'
            ];
            $sampleData = [
                'Access Control Review',
                'Implement quarterly access review process',
                'ongoing',
                'High',
                date('Y-m-d', strtotime('+30 days')),
                'Security Manager',
                'Preventive',
                'Strong'
            ];
            break;
        default:
            $filename = 'Default_Template.csv';
            $headers = ['Risk Name*', 'Risk Category', 'Process', 'Cause*'];
    }

    // Output CSV file
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $output = fopen('php://output', 'w');

    // Write headers
    fputcsv($output, $headers);

    // Write sample data if available
    if (!empty($sampleData)) {
        fputcsv($output, $sampleData);
    }

    fclose($output);
    exit;
}

function generateRiskTemplate($worksheet) {
    $headers = [
        'Risk Name*', 'Risk Category', 'Process', 'Cause*', 'Consequence',
        'Risk Owner', 'Inherent Likelihood', 'Inherent Impact',
        'Existing Controls', 'Residual Likelihood', 'Residual Impact'
    ];

    $worksheet->fromArray($headers, null, 'A1');

    // Add sample data
    $sampleData = [
        [
            'Data breach due to system vulnerability',
            'Information Security',
            'IT Operations',
            'Outdated security patches and weak access controls',
            'Loss of confidential data, regulatory fines, reputation damage',
            'IT Manager',
            '3',
            '4',
            'Firewall, antivirus, access controls',
            '2',
            '3'
        ]
    ];

    $worksheet->fromArray($sampleData, null, 'A2');
}

function generateCompleteTemplate($worksheet) {
    $headers = [
        'Incident', 'Dept ID', 'Process ID', 'Risk ID', 'Date of Loss',
        'Actual', 'Expected', 'Potential', 'Recovery', 'Action ID'
    ];

    $worksheet->fromArray($headers, null, 'A1');
}

function generateControlTemplate($worksheet) {
    $headers = [
        'Control Name', 'Action Name*', 'Status', 'Priority', 'Timeline',
        'Owner', 'Control Type', 'Control Strength'
    ];

    $worksheet->fromArray($headers, null, 'A1');

    // Add sample data
    $sampleData = [
        [
            'Access Control Review',
            'Implement quarterly access review process',
            'ongoing',
            'High',
            date('Y-m-d', strtotime('+30 days')),
            'Security Manager',
            'Preventive',
            'Strong'
        ]
    ];

    $worksheet->fromArray($sampleData, null, 'A2');
}

// Process the download request
$type = $_GET['type'] ?? 'risks';
generateTemplate($type);
?>


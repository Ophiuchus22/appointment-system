<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Administrative Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .section {
            margin-bottom: 30px;
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #2563eb;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Administrative Report</h1>
        <p>Generated on: {{ $generated_at }}</p>
        <p>Report Period: {{ $date_range['start'] }} to {{ $date_range['end'] }}</p>
    </div>

    @if(in_array('appointment_overview', $reportTypes))
    <div class="section">
        <div class="section-title">Appointment Status Overview</div>
        <table>
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Count</th>
                </tr>
            </thead>
            <tbody>
                @foreach($appointmentStats as $status => $count)
                    <tr>
                        <td>{{ ucfirst($status) }}</td>
                        <td>{{ $count }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <div class="section-title">College Distribution</div>
        <table>
            <thead>
                <tr>
                    <th>College</th>
                    <th>Total Appointments</th>
                </tr>
            </thead>
            <tbody>
                @foreach($collegeStats as $stat)
                    <tr>
                        <td>{{ $stat->college_office }}</td>
                        <td>{{ $stat->count }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    @if(in_array('user_activity', $reportTypes))
    <div class="section">
        <div class="section-title">Most Frequent Appointment Makers</div>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>College</th>
                    <th>Total Appointments</th>
                </tr>
            </thead>
            <tbody>
                @foreach($frequentUsers as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->college_office }}</td>
                        <td>{{ $user->appointment_count }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    @if(in_array('purpose_analysis', $reportTypes))
    <div class="section">
        <div class="section-title">Most Common Purposes</div>
        <table>
            <thead>
                <tr>
                    <th>Purpose</th>
                    <th>Count</th>
                </tr>
            </thead>
            <tbody>
                @foreach($commonPurposes as $purpose)
                    <tr>
                        <td>{{ $purpose->purpose }}</td>
                        <td>{{ $purpose->count }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <div class="footer">
        <p>This is an automatically generated report. Please keep for your records.</p>
    </div>
</body>
</html> 
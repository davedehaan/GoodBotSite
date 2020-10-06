<html>
<head>
    <style>
        body {
            background: #333;
            color: #fff;
            font-family: sans-serif;
        }
        #logo {
            top: 0;
            left: 50%;
            margin-left: -129px;
            position: absolute;
        }
        .metric {
            width: 48%;
            height: 44%;
            float: left;
            padding: 2% 1% 9;
        }
        .logs {
            width: 48%;
            height: 96%;
            padding: 2% 1% 0;
            float: left;
            overflow: hidden;
        }
        h2 {
            text-align: center;
        }
        table {
            width: 100%;
            border: solid 1px #aaa;
        }
        table th {
            text-align: left;
            font-weight: normal;
            font-size: .9em;
        }
        table td {
            font-size: .9em;
            border-top: dotted 1px #aaa;
        }
    </style>
</head>
<body>
    <img src="/assets/img/GoodBot.png" id="logo" />
    <div class="logs">
        <h2>Logs</h2>
        <table>
        @foreach ($logs AS $log)
        <tr>
            <td>
            {{ $log->event }}
            </td>
        </tr>
        @endforeach
    </table>
    </div>
    <div class="metric">
        <h2>Latest Guilds</h2>        
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Added At</th>
            </tr>
        @foreach ($guilds AS $guild)
            <tr>
                <td>
                {{ $guild->guildID }}
                </td>
                <td>
                {{ $guild->name }}
                </td>
                <td>
                {{ $guild->createdAt }}
                </td>
            </tr>
        @endforeach
        </table>
    </div>
    <div class="metric">
        <h2>Latest Raids</h2>
        <table>
            <tr>
                <th>Name</th>
                <th>Raid</th>
                <th>Signups</th>
                <th>Guild</th>
                <th>Created</th>
            </tr>
        @foreach ($raids AS $raid)
            <tr>
            <td>
                {{ $raid->name }}
                </td>
                <td>
                {{ $raid->raid }}
                </td>
                <td>
                {{ $raid->signups->count() }}
                </td>
                <td>
                {{ $raid->Guild ? $raid->Guild->name : '-' }}
                </td>
                <td>
                {{ $raid->createdAt }}
                </td>
            </tr>
        @endforeach
    </table>
    </div>
    <script>
        setTimeout(() => {
            location.reload();
        }, 30000);
    </script>
</body>
</html>
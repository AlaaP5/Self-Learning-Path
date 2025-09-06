<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: "Tahoma", sans-serif;
            line-height: 1.8;
            direction: rtl;
            background-color: #f9f9f9;
            padding: 20px;
        }
        .card {
            background: #ffffff;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        h2 {
            color: #2c3e50;
        }
        ul {
            list-style-type: "✅ ";
            padding-right: 20px;
        }
        .note {
            margin-top: 15px;
            padding: 10px;
            background: #fef6d8;
            border-right: 5px solid #f1c40f;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="card">
        <h2>📩 مسارك التعليمي</h2>
        <p><strong>{{ explode("\n", $content)[0] }}</strong></p>

        <ul>
            @php
                $lines = explode("\n", $content);
                array_shift($lines);
                $note = array_pop($lines);
            @endphp

            @foreach($lines as $line)
                @if(trim($line) !== '')
                    <li>{{ $line }}</li>
                @endif
            @endforeach
        </ul>

        <div class="note">
            💡 {{ $note }}
        </div>
    </div>
</body>
</html>

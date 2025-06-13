<!DOCTYPE html>
<html>

<head>
    <style>
        @page {
            size: 8.5cm 10cm;
            margin: 0;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .sheet {
            position: relative;
            width: 8.5cm;
            height: 10cm;
        }

        .tag {
            position: absolute;
            width: 3.5cm;
            height: 0.7cm;
            font-size: 8.5px;
            padding: 1mm;
            box-sizing: border-box;
            display: flex;
            justify-content: space-between;
            border: 1px solid;
            border-radius: 3px;
            font-size: 5px;
        }

        .tag .left {
            text-align: left;
        }

        .tag .right {
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="sheet">
        @foreach ($products as $index => $p)
            @php
                // $col = $index % 2 === 0 ? 0 : 1; // left or right
                // $row = intdiv($index, 2);
                // $x = $col === 0 ? 0 : 5; // 0cm or 5cm (body left or right)
                // $y = $row * 1; // vertical step (1cm per row)

                $x = $index % 2 === 0 ? 0 : 5; // Left or right
                $y = $index * 0.5; // Each tag gets its own row (0.5cm tall)
            @endphp

            <div class="tag" style="top: {{ $y }}cm; left: {{ $x }}cm;">
                <div class="left">
                    <div>{{ $p->product_no }}</div>
                    <div>{{ $p->name }}</div>
                    <div>₹{{ number_format($p->mrp, 0) }}</div>
                </div>
                <div class="right">
                    @if ($p->diamond_qty > 0)
                        <div>D - {{ $p->diamond_qty }}K</div>
                    @endif
                    @if ($p->color_stone_qty > 0)
                        <div>C - {{ $p->color_stone_qty }}K</div>
                    @endif
                    @if ($p->gold_qty > 0)
                        <div>G - {{ $p->gold_qty }}Gm ({{ $p->gold_carat }})</div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</body>

</html>

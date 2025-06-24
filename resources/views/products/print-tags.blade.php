<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Jewellery Tags</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        /* body {
            padding: 20px;
            background-color: #f9f9f9;
        } */

        .page {
            width: 137mm;
            height: 175mm;
            background: white;
            /* padding: 20px; */
            display: flex;
            gap: 0;
            border-radius: 4mm;
            /* margin-left: 250px; */
        }

        .left-column,
        .right-column {
            display: flex;
            flex-direction: column;
            gap: 3mm;
        }

        .right-column {
            margin-top: 7.5mm;
            /* margin-left: -1px; */

        }

        .left-tag,
        .right-tag {
            width: 63mm;
            height: 13mm;
            background-color: white;
            border-radius: 2mm;
            display: flex;
            overflow: hidden;
            box-shadow: 1px 1px 4px rgba(182, 188, 197, 0.877);
            position: relative;
        }

        .left-tag::before,
        .right-tag::before,
        .left-tag::after,
        .right-tag::after {
            content: "";
            position: absolute;
            left: 50%;
            width: 8px;
            height: 5px;
            background: white;
            transform: translateX(-50%);
            z-index: 1;
        }

        .left-tag::before,
        .right-tag::before {
            top: 0;
            clip-path: polygon(0 0, 100% 0, 50% 100%);
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
            border-top-left-radius: 2mm;
            border-top-right-radius: 2mm;
        }

        .left-tag::after,
        .right-tag::after {
            bottom: 0;
            clip-path: polygon(0 100%, 100% 100%, 50% 0);
            box-shadow: 0 -1px 2px rgba(0, 0, 0, 0.2);
            border-bottom-left-radius: 2mm;
            border-bottom-right-radius: 2mm;
        }

        .tag-section {
            width: 50%;
            height: 100%;
            display: flex;
            align-items: start;
            justify-content: start;
            font-size: 9px;
        }

        .left-half {
            border: 1px solid rgba(36, 9, 9, 0.5);
            border-right: none;
            border-top-left-radius: 1.5mm;
            border-bottom-left-radius: 1.5mm;
            border-bottom-right-radius: 1.5mm;
            border-top-right-radius: 1.5mm;
            border-color: rgb(167, 191, 204);
            border-top-color: silver;
            border-left: transparent;
            border-bottom-color: silver;

        }

        .right-half {
            border: 1px solid rgba(36, 9, 9, 0.5);
            border-left: none;
            border-top-right-radius: 1.5mm;
            border-bottom-right-radius: 1.5mm;
            border-bottom-left-radius: 1.5mm;
            border-top-left-radius: 1.5mm;
            border-color: rgb(167, 191, 204);
            border-top-color: silver;
            border-right: transparent;
            border-bottom-color: silver;
        }

        .tag-content {
            margin-left: 10px
        }
    </style>
</head>

<body>
    <div class="page">
        <div class="left-column">
            @foreach ($leftTagProducts as $product)
                <div class="left-tag">
                    <div class="tag-section left-half flex-column">
                        <div class="tag-content">{{ $product['product_no'] }}</div>
                        <div class="tag-content">{{ $product['name'] }}</div>
                        <div class="tag-content">₹{{ $product['mrp'] }}</div>
                    </div>
                    <div class="tag-section right-half flex-column">
                        <div class="tag-content">{{ $product['diamong'] ?? '' }}</div>
                        <div class="tag-content">{{ $product['color_stone'] ?? '' }}</div>
                        <div class="tag-content">{{ $product['gold'] ?? '' }}</div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="right-column">
            @foreach ($rightTagProducts as $product)
                <div class="right-tag">
                    <div class="tag-section left-half flex-column">
                        <div class="tag-content">{{ $product['product_no'] }}</div>
                        <div class="tag-content">{{ $product['name'] }}</div>
                        <div class="tag-content">₹{{ $product['mrp'] }}</div>
                    </div>
                    <div class="tag-section right-half flex-column">
                        <div class="tag-content">{{ $product['diamong'] ?? '' }}</div>
                        <div class="tag-content">{{ $product['color_stone'] ?? '' }}</div>
                        <div class="tag-content">{{ $product['gold'] ?? '' }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</body>

</html>

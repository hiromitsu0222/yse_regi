<?php
require_once "db.php";

if (isset($_POST['number']) || isset($_POST['operator']) || isset($_POST['clear']) || isset($_POST['calculate']) || isset($_POST['add_tax']) || isset($_POST['backspace']) || isset($_POST['record']) || isset($_POST['sales'])) {
    if (isset($_POST['clear'])) {
        $expression = '';
    } elseif (isset($_POST['backspace'])) {
        $expression = $_POST['expression'] ?? '';
        $expression = substr($expression, 0, -1); // Remove last character
    } else {
        $expression = $_POST['expression'] ?? '';
        if (isset($_POST['number'])) {
            $expression .= $_POST['number'];
        } elseif (isset($_POST['operator'])) {
            $expression .= ' ' . $_POST['operator'] . ' ';
        } elseif (isset($_POST['calculate'])) {
            // Evaluate the expression
            $expression = eval("return ($expression);");
        } elseif (isset($_POST['add_tax'])) {
            // Add tax
            $expression = eval("return ($expression) * 1.1;");
        } elseif (isset($_POST['record'])) {
            // Record logic here
            $price = $_POST['expression'];
            $sql = "INSERT INTO sales (price) VALUES (1000);";
            $pdo->query($sql);
            $expression = "";
        } elseif (isset($_POST['sales'])) {
            // Sales logic here
            $expression = "Sales!";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tailwind CSS Calculator</title>
    </head>
<body>
    <h1>税込み価格計算</h1>
    <form method="post">
        <label for="amount">金額 (円):</label>
        <input type="text" id="amount" name="amount" required>
        <input type="submit" name="submit" value="計算">
    </form>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['submit']) && is_numeric($_POST['amount'])) {
            $amount = $_POST['amount'];
            $taxRate = 1.10; // 10% の税
            $totalAmount = $amount * $taxRate;
            echo "<p>税込み価格: " . number_format($totalAmount, 2) . " 円</p>";
        } else {
            echo "<p>正しい金額を入力してください。</p>";
        }
    }
    ?>
    <!-- Tailwind CSSのCDNリンク -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>
    <div class="bg-gray-200 flex justify-center items-center h-screen">
        <div class="calculator bg-white rounded p-8 shadow-md">
            <div class="d-flex w-full mt-3 mb-3">
                <form action="update.php" method="post">
                    <input type="text" id="display" name="price" class="w-full mb-4 px-2 py-1 border rounded" readonly>
                    <div>
                        <button class="btn border p-3" onclick="update()">計上</button>
                        <a class="btn border p-3" href="sales/">売上</a>
                    </div>
                </form>
            </div>
            <div class="grid grid-cols-4 gap-4">
                <button class="btn" onclick="addToDisplay('7')">7</button>
                <button class="btn" onclick="addToDisplay('8')">8</button>
                <button class="btn" onclick="addToDisplay('9')">9</button>
                <button class="btn" onclick="clearAll()">AC</button>
                <button class="btn" onclick="addToDisplay('4')">4</button>
                <button class="btn" onclick="addToDisplay('5')">5</button>
                <button class="btn" onclick="addToDisplay('6')">6</button>
                <button class="btn" onclick="calculate('+')">+</button>
                <button class="btn" onclick="addToDisplay('1')">1</button>
                <button class="btn" onclick="addToDisplay('2')">2</button>
                <button class="btn" onclick="addToDisplay('3')">3</button>
                <button class="btn" onclick="calculate('*')">x</button>
                <button class="btn" onclick="addToDisplay('0')">0</button>
                <button class="btn" onclick="">Tax</button>
                <button class="btn" onclick="calculateTotal()">=</button>
            </div>
        </div>
    </div>

    <script>
        var memory = "";
        var operand = "";

        function addToDisplay(value) {
            memory += value;
            updateDisplay();
        }

        function calculate(value) {
            operand = value;
            memory += value;
        }

        function clearAll() {
            memory = "";
            updateDisplay();
        }

        function updateDisplay() {
            document.getElementById('display').value = memory;
        }

        function calculateTotal() {
            var expression = document.getElementById('display').value;
            var result = eval(expression);
            document.getElementById('display').value = result;
        }
    </script>

    </div>
</body>

</html>
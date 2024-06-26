<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tailwind CSS Calculator</title>
    <!-- Tailwind CSSのCDNリンク -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <h1>税込み価格計算</h1>
    <form method="post">
        <label for="amount"></label>
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
            echo "<p></p>";
        }
    }
    ?>
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
            <button class="btn bg-gray-200 p-3 rounded" onclick="addToDisplay('7')">7</button>
            <button class="btn bg-gray-200 p-3 rounded" onclick="addToDisplay('8')">8</button>
            <button class="btn bg-gray-200 p-3 rounded" onclick="addToDisplay('9')">9</button>
            <button class="btn bg-red-500 text-white p-3 rounded" onclick="clearAll()">AC</button>
            <button class="btn bg-gray-200 p-3 rounded" onclick="addToDisplay('4')">4</button>
            <button class="btn bg-gray-200 p-3 rounded" onclick="addToDisplay('5')">5</button>
            <button class="btn bg-gray-200 p-3 rounded" onclick="addToDisplay('6')">6</button>
            <button class="btn bg-gray-200 p-3 rounded" onclick="calculate('+')">+</button>
            <button class="btn bg-gray-200 p-3 rounded" onclick="addToDisplay('1')">1</button>
            <button class="btn bg-gray-200 p-3 rounded" onclick="addToDisplay('2')">2</button>
            <button class="btn bg-gray-200 p-3 rounded" onclick="addToDisplay('3')">3</button>
            <button class="btn bg-gray-200 p-3 rounded" onclick="calculate('*')">x</button>
            <button class="btn bg-gray-200 p-3 rounded" onclick="addToDisplay('0')">0</button>
            <button class="btn bg-gray-200 p-3 rounded" onclick="addTax()">Tax</button>
            <button class="btn bg-green-500 text-white p-3 rounded" onclick="calculateTotal()">=</button>
        </div>        </div>
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

        // 消費税を加算する関数
        function addTax() {
            var display = document.getElementById('display');
            var currentValue = display.value;
            
            // 現在の表示値が数値でない場合は処理しない
            if (isNaN(currentValue)) {
                return;
            }
            
            // 数値に変換して消費税を加算し、表示を更新する
            var amount = parseFloat(currentValue);
            var taxRate = 0.10; // 10% の消費税
            var totalAmount = amount * (1 + taxRate);
            display.value = totalAmount.toFixed(2); // 2桁までの小数点以下表示
        }
    </script>

</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tailwind CSS Calculator</title>
    <!-- Tailwind CSSのCDNリンク -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
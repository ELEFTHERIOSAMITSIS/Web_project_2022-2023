<!DOCTYPE html>
<html>
<head>
    <title>Discount Percentage Chart</title>
    <link rel="stylesheet" type="text/css" href="../css/chart.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<form method="post" action="" id="myform">
    <label class="label" for="category">Select Category:</label>
    <select class="select" name="category" id="category">
        <option value="">Select a Category</option>
            </select>
    <label class="label" for="subcategory">Select Subcategory:</label>
    <select class="select" name="subcategory" id="subcategory">
        <option value="">Select a Subcategory</option>
    </select>
    <input type="hidden" name="selectedCategory" id="selectedCategory" value="">
    <input type="hidden" name="selectedSubcategory" id="selectedSubcategory" value="">
    <button class="button" type="submit" name="showDiscountChart">Show Chart</button>
</form>


    <div id="box">
    <h1 id="chartTitle">Discount Percentage Chart</h1>
    <canvas id="offerChart"></canvas>
</div>

<script src="chart_test.js"></script>

</body>
</html>
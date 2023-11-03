document.addEventListener("DOMContentLoaded", function () {
    const categorySelect = document.getElementById("category");
    const subcategorySelect = document.getElementById("subcategory");
    let selectedCategory = "";
    let selectedSubcategory = "";
    const selectedCategoryInput = document.getElementById("selectedCategory");
    const selectedSubcategoryInput = document.getElementById("selectedSubcategory");
    const chartContainer = document.getElementById("box");
    const showChartButton = document.getElementsByName("showDiscountChart")[0];

    fetch("../jsons/products_and_categories.json")
        .then((response) => response.json())
        .then((data) => {
            data.categories.forEach((category) => {
                const option = document.createElement("option");
                option.value = category.id;
                option.textContent = category.name;
                categorySelect.appendChild(option);
            });

            categorySelect.addEventListener("change", () => {
                selectedCategory = categorySelect.value;
                selectedCategoryInput.value = selectedCategory;

                const selectedCategoryId = categorySelect.value;
                subcategorySelect.innerHTML = '<option value="">Select a Subcategory</option>';

                if (selectedCategoryId) {
                    const selectedCategory = data.categories.find((category) => category.id === selectedCategoryId);

                    selectedCategory.subcategories.forEach((subcategory) => {
                        const option = document.createElement("option");
                        option.value = subcategory.uuid;
                        option.textContent = subcategory.name;
                        subcategorySelect.appendChild(option);
                    });
                }
            });
        })
        .catch((error) => {
            console.error("Error loading categories:", error);
        });

    subcategorySelect.addEventListener("change", () => {
        selectedSubcategory = subcategorySelect.value;
        selectedSubcategoryInput.value = selectedSubcategory;
    });

        showChartButton.addEventListener("click", (e) => {
            e.preventDefault(); // Prevent the form from submitting

            const selectedCategory = categorySelect.value;
            const selectedSubcategory = subcategorySelect.value;
            const catsub= new FormData();
            catsub.append("category",selectedCategory);
            catsub.append("subcategory",selectedSubcategory);
            var Dataset;
            var retreiver = new XMLHttpRequest();
            retreiver.open("POST", "chart_data.php", true);
            retreiver.onload = function () {
                if (this.readyState === 4 && this.status === 200) {
                    console.log(this.responseText);
                    Dataset = JSON.parse(this.responseText);
                    for(const data of Dataset ){
                    const dateParts = data.date.split(' '); // Split the string at the space character
                    const dateOnly = dateParts[0];
                    // Convert the date to the format used in dateLabels
                    const dateObject = new Date(dateOnly);
                    const formattedDateLabel = dateObject.toLocaleDateString('en-US', {
                        weekday: 'short',
                        year: 'numeric',
                        month: 'numeric',
                        day: 'numeric'
                    });
                    // const chartTitleText = `Discount Percentage Chart for: ${selectedCategory} - ${selectedSubcategory}`;
                    // const chartTitle = document.getElementById("chartTitle");
                    // chartTitle.textContent = chartTitleText;
                    addDataToChart(discountChart, formattedDateLabel, data.average);
        
                    chartContainer.style.display = "block";}
                }
            };
            retreiver.send(catsub);
        });

    function getDateLabelsForCurrentWeek() {
        const today = new Date();
        const currentDayOfWeek = today.getDay();

        const startDate = new Date(today);
        startDate.setDate(today.getDate() - currentDayOfWeek);

        const dateLabels = [];

        for (let i = 0; i < 7; i++) {
            const date = new Date(startDate);
            date.setDate(startDate.getDate() + i);
            const formattedDate = date.toLocaleDateString('en-US', {
                weekday: 'short',
                year: 'numeric',
                month: 'numeric',
                day: 'numeric'
            });
            dateLabels.push(formattedDate);
        }

        return dateLabels;
    }

    const dateLabels = getDateLabelsForCurrentWeek();


        const ctx = document.getElementById("offerChart").getContext("2d");
    
        const discountChart = new Chart(ctx, {
            type: 'bar',
        data: {
            labels: dateLabels,  
            datasets: [{
                label: 'Discounts for the Week',
                data: [], // Start with an empty array
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
            }] 
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Discount Percentage'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Days of the week'
                    }
                }
            }
        }
        });
    
        discountChart.update();
    
});

function addDataToChart(chart, date, data) {
    if (chart.data.datasets.length > 0) {
        const dayIndex = chart.data.labels.indexOf(date); 
        if (dayIndex >= 0) {
            chart.data.datasets[0].data[dayIndex] = data;
            chart.update();
        } else {
            console.error("Date not found in chart labels.");
        }
    } else {
        console.error("No datasets are defined in the chart.");
    }
}
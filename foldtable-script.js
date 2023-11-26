jQuery(document).ready(function ($) {

    console.log("document is ready to use.");
    // Get all category checkboxes
    var categoryCheckboxes = $('input[name="category"]');

    console.log(categoryCheckboxes);
    // Attach event listener to each category checkbox
    categoryCheckboxes.on("change", function () {
        // Get the selected categories
        var selectedCategories = [];
        categoryCheckboxes.each(function () {
            if ($(this).is(":checked")) {
                selectedCategories.push($(this).val());
            }
        });

        console.log( selectedCategories);
        // Make an AJAX request to fetch filtered products
        $.ajax({
            type: "POST",
            url: "/wp-admin/admin-ajax.php",
            data: {
                action: "filter_products",
                categories: JSON.stringify(selectedCategories),
            },
            success: function (response) {
                // Update the product list with the filtered products
                $(".product-list").html(response);
            },
        });
    });

    $(".tassawer tr.view .license-key-btn").on("click", function () {
        $(this).closest("tr").toggleClass("open");
        $(this).closest("tr").next(".fold").toggleClass("open");
    });
});



<?php
/*
Template Name: Music Template
Description: A custom page template for your content.
*/
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet"
        href="<?php echo home_url();?>/wp-content/themes/astra-child/assets/css/font-awesome.min.css">
    <link href="https://fonts.cdnfonts.com/css/montserrat" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo home_url();?>/wp-content/themes/astra-child/style.css">
    <title>Cinematic HUB</title>
</head>

<body class="position-relative">
    <div class="modal fade modal-popup" tabindex="-1" role="dialog" id="signupModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="inner-modal-popup text-center d-flex align-items-center">
                    <div class="close-icon">X</div>
                    <h2>Cinematic HUB</h2>
                    <div class="heads-desc">
                        <p>In order to view this part of HUB <br>you must have an active subscription.</p>
                        <p>Sign up below and get your first month FREE!</p>
                    </div>
                    <div class="row list-main">
                        <div class="col-12 text-center">
                            <div class="row">
                                <div class="col-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none">
                                        <path
                                            d="M15 10L11 14L9 12M12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12C21 16.9706 16.9706 21 12 21Z"
                                            stroke="url(#paint0_linear_365_2601)" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                        <defs>
                                            <linearGradient id="paint0_linear_365_2601" x1="12" y1="3" x2="12" y2="21"
                                                gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#0C92FD" />
                                                <stop offset="1" stop-color="#631AFF" />
                                            </linearGradient>
                                        </defs>
                                    </svg>
                                </div>
                                <div class="col-10">
                                    <div class="list-text">
                                        $0 to sign up for your first month
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none">
                                        <path
                                            d="M15 10L11 14L9 12M12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12C21 16.9706 16.9706 21 12 21Z"
                                            stroke="url(#paint0_linear_365_2601)" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                        <defs>
                                            <linearGradient id="paint0_linear_365_2601" x1="12" y1="3" x2="12" y2="21"
                                                gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#0C92FD" />
                                                <stop offset="1" stop-color="#631AFF" />
                                            </linearGradient>
                                        </defs>
                                    </svg>
                                </div>
                                <div class="col-10">
                                    <div class="list-text">
                                        $0 to sign up for your first month
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none">
                                        <path
                                            d="M15 10L11 14L9 12M12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12C21 16.9706 16.9706 21 12 21Z"
                                            stroke="url(#paint0_linear_365_2601)" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                        <defs>
                                            <linearGradient id="paint0_linear_365_2601" x1="12" y1="3" x2="12" y2="21"
                                                gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#0C92FD" />
                                                <stop offset="1" stop-color="#631AFF" />
                                            </linearGradient>
                                        </defs>
                                    </svg>
                                </div>
                                <div class="col-10">
                                    <div class="list-text">
                                        $0 to sign up for your first month
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="<?php echo home_url();?>/checkout/" class="btn sign-up-btn">
                        SIGN UP FREE
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div id="loadingIndicator" style="display: none;">
        <div class="spinner-border text-primary" role="status" style="position: absolute; top: 50%; left: 50%;">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <div class="container-fluid p-0">
        <div class="top-bar-main top-bar-bg">
            <div class="inner-top-bar overflow-hidden">
                <div class="row p-2">
                    <div class="col-2 d-flex justify-content-start align-items-center d-none d-sm-block">
                        <img src="<?php echo home_url();?>/wp-content/themes/astra-child/assets/images/Menu Toggle.png"
                            alt="Toggle Menu Button" srcset="">
                    </div>
                    <div class="col-8 d-flex justify-content-sm-center align-items-center me-auto me-sm-0">
                        <img src="<?php echo home_url();?>/wp-content/themes/astra-child/assets/images/cinematic-hub.png"
                            alt="Cinematic-HUB" srcset="">
                    </div>
                    <div class="col-2 d-flex justify-content-end align-items-center">
                        <?php
                        $user_id = get_current_user_id();
						if ($user_id !== 0) {
                            $user_data = get_userdata($user_id);
                            echo '<div style="margin-right: 10px; color: #fff;">' . $user_data->user_login . '</div>';
                        } else {
                            echo '<a href="' . home_url("/login/") . '" style="margin-right: 10px; color: #fff;">login</a>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="tabs-menu-main">
            <div
                class="inner-tabs-menu tab-bg justify-content-center justify-content-md-start justify-content-lg-center align-items-end align-items-md-center px-4">
                <ul>
                    <li id="browse-tab" class="active">Browse</li>
                    <li id="favorite-tab">Favorites</li>
                    <li id="my-hub">My Hub</li>

                </ul>
                <!-- <button class="btn trial-btn">Start Free Now</button> -->
                <?php
                    $user_id = get_current_user_id();
                    if ($user_id != 0) {
						 $credit_balance = get_user_meta($user_id, 'credit_balance', true);
						if( $credit_balance && $credit_balance != 0)
                        	echo '<button class="btn credits">' . get_user_meta( get_current_user_id(), "credit_balance", true) . '/40 CREDITS</button>';
						else 
							echo '<a class="buy-credits" href="' . home_url() . '/checkout/?add-to-cart=35136">Buy Credits</a>';
                    } else {
                        echo '<button class="btn trial-btn">Start Free Now</button>';
                    }
                ?>
            </div>
        </div>

        <div class="categories-tab-main">
            <div class="inner-categories-tab">
                <ul class="p-0">
                    <?php
                    // Get all product categories
                    $categories = get_terms(
                        array(
                            'taxonomy' => 'music_category',
                            'hide_empty' => true,
                        )
                    );

                    $total_categories = 0;
                    // Calculate the midpoint to split the categories
                    foreach ($categories as $category):
                        if ($category->parent == 0):
                            $total_categories++;
                        endif;
                    endforeach;

                    $midpoint = floor($total_categories / 2);

                    // Output categories for the first row
                    $count = 0;
                    foreach ($categories as $category):
                        if ($category->parent == 0):
                            ?>
                    <li value="<?php echo esc_html($category->term_id); ?>">
                        <?php echo esc_html(strtoupper($category->name)); ?>
                    </li>
                    <?php
                            $count++;
                            if ($count >= $midpoint) {
                                break; // Stop outputting categories for the first row
                            }

                        endif;
                    endforeach;
                    ?>
                </ul>
                <ul class="pt-2 ps-0">
                    <?php
                    //Output categories for the second row
                    $count = 0;
                    foreach ($categories as $category):
                        if ($category->parent == 0):
                            if ($count >= $midpoint):
                                ?>
                    <li value="<?php echo esc_html($category->term_id); ?>">
                        <?php echo esc_html(strtoupper($category->name)); ?>
                    </li>
                    <?php
                            endif;
                            $count++;
                        endif;

                    endforeach;
                    ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="page-wrapper position-static">
        <div class="sidebar-overlay"></div>
        <div class="sidebar-main">
            <div class="w-100 h-100">
                <div class="inner-sidebar">
                    <div class="search-bg d-lg-none">
                        <div class="inner-search-bg">
                            <form role="search" method="get" class="search-form" action="#">
                                <button type="submit" class="search-submit"><i class="fa fa-search"></i></button>
                                <input type="search" class="music-search" name="search" placeholder="Search for Sounds">
                            </form>
                        </div>
                    </div>

                    <h3>CATEGORIES</h3>

                    <div class="categories-check-lists">
                        <?php
                        $categories = get_terms(
                            array(
                                'taxonomy' => 'music_category',
                                'hide_empty' => true,
                            )
                        );
                        foreach ($categories as $category):
                            if ($category->parent == 0):
                                ?>
                        <div class="form-check my-2">
                            <input class="form-check-input" name="category" type="checkbox"
                                value="<?php echo esc_attr($category->term_id); ?>"
                                id="category_<?php echo esc_attr($category->term_id); ?>" data-parent="0">
                            <label class="form-check-label mx-2"
                                for="category_<?php echo esc_attr($category->term_id); ?>">
                                <?php echo esc_html($category->name); ?>
                            </label>
                        </div>
                        <?php
                                display_child_categories($categories, $category->term_id, 1);
                            endif;
                        endforeach;

                        function display_child_categories($categories, $parent_id, $level)
                        {
                            foreach ($categories as $category) {

                                if ($category->parent == $parent_id) {

                                    echo '<div class="form-check my-2"><input class="form-check-input mx-' . $level . '"  name="category" type="checkbox" value="' . esc_attr($category->term_id) . '" id="category_' . esc_attr($category->term_id) . '" data-parent="' . $parent_id . '"><label class="form-check-label mx-2" for="category_' . esc_attr($category->term_id) . '">' . esc_html($category->name) . '
                                    </label></div>';
                                    display_child_categories($categories, $category->term_id, $level + 1);
                                }
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <span class="sidebar-toggle navbar-toggler-icon d-lg-none"><i class="fa fa-chevron-right"
                    aria-hidden="true"></i><i class="fa fa-chevron-left" aria-hidden="true"
                    style="display:none"></i></span>
        </div>
        <div class="main-page">
            <div class="inner-main-page">
                <div class="singer-info" style="display: none;">
                    <?php
                    $author_id = $_GET['author_id'];
                    $author_info = get_userdata($author_id);

                    $author_description = $author_info->description;
                    $avatar = get_avatar($author_id, 200, '', '', array('class' => 'rounded-circle'));
                    if (strpos($avatar, 'gravatar.com') === false) {
                        $default_avatar = get_option('avatar_default');
                        $avatar = "<img src='https://secure.gravatar.com/avatar/46b74cbf716eaa88cd3c2e695356d348?s=32&d=mm&f=y&r=g' class='rounded-circle' alt='Default Avatar'>";
                    }

                    echo '<figure>
                                <input type="hidden" value="' . $author_id . '"/>
                                <a href="#">' . $avatar . '</a>
                            </figure>
                            <div class="singer-description">
                                <h4 class="singer-name">' . $author_info->display_name . '&nbsp;</h4>
                                <p class="singer-role">' . $author_info->description . '&nbsp;</p>
                                <button class="btn browse-btn">Browse</buttton>' .
                        '</div>';
                    ?>
                </div>
                <div class="music-main">
                    <div class="search-bg d-none d-lg-block">
                        <div class="inner-search-bg">
                            <form role="search" method="get" class="search-form" action="#">
                                <button type="submit" class="search-submit"><i class="fa fa-search"></i></button>
                                <input type="search" class="music-search" name="search" placeholder="Search for Sounds">
                            </form>
                            <ul class="category-badgets">
                            </ul>
                            <span class="clear-filters" style="display:none">CLEAR ALL<span>
                        </div>
                    </div>
                    <div class="row mt-4 mx-0 d-none d-md-flex">
                        <div class="col-xl-1 col-md-1"></div>
                        <div class="col-xl-2 col-md-2">
                            <div class="title">
                                <h4>Title</h4>
                            </div>
                        </div>
                        <div class="col-xl-2 col-md-3"></div>
                        <div class="col-xl-1 col-md-2">
                            <div class="title text-center">
                                <h4>Tempo</h4>
                            </div>
                        </div>
                        <div class="col-xl-1 col-md-2">
                            <div class="title text-center">
                                <h4>Key</h4>
                            </div>
                        </div>
                        <div class="col-xl-1 col-md-2">
                            <div class="title text-center">
                                <h4>Library</h4>
                            </div>
                        </div>
                        <div class="col-xl-2 col-md-8 d-none d-xl-block">
                            <div class="title">
                                <h4>Tags</h4>
                            </div>
                        </div>
                        <div class="col-xl-2 col-md-4 d-none d-xl-block"></div>
                    </div>
                    <div class="product-list">

                        <div class="audio-bg mt-3 text-white text-center">There is no music to show</div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://use.fontawesome.com/a563198eca.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script>
    jQuery(document).ready(function($) {

        var myModal = new bootstrap.Modal($('#signupModal'), {
            keyboard: false
        });

//         setTimeout(function() {
//             myModal.show();
//         }, 5000);

        $(".close-icon").click(function() {
            myModal.hide();
        });

        var categoryCheckboxes = $('input[name="category"]');

        // Attach event listener to each category checkbox
        categoryCheckboxes.on("change", function() {
            changeCategoryFunction($(this));
        });

        $(document).on("click", ".category-badgets > li", function() {
            var element = $("#category_" + $(this).val());
            element.click();
            // changeCategoryFunction(element);
        });

        // $(document).on("click", ".row.audio-bg.mt-3 > :not(:nth-child(3)):not(:last-child)", function() {
        //     console.log("Browse button must me shown.")
        //     $('.categories-tab-main').hide();
        //     $('.singer-info').show();
        // });

        // $(document).on("click", "button.btn.browse-btn", function() {
        //     $('.categories-tab-main').show();
        //     $('.singer-info').hide();
        // });


        $(document).on("click", ".sidebar-toggle", function() {
            $('body').toggleClass('sidebar-open');
            $(this).find("i").toggle();
        });

        $(document).on("click", ".sidebar-overlay", function() {
            $('body').removeClass('sidebar-open');
            $(this).find("i").toggle();
        });

        $(document).on("click", ".inner-categories-tab ul li", function() {
            var element = $("#category_" + $(this).val());
            element.click();
            // changeCategoryFunction(element);
        });

        $(".clear-filters").click(function() {
            $(".categories-check-lists > div.form-check > input[name='category']").prop('checked',
                false);
            $(".category-badgets li").remove();
            $(".inner-categories-tab ul li").removeClass("active");
            $(".clear-filters").hide();
            $(".product-list").html(
                "<div class=\"audio-bg mt-3 text-white text-center\">There is no music to show</div>"
            );
        });

        $(".tassawer tr.view .license-key-btn").on("click", function() {
            $(this).closest("tr").toggleClass("open");
            $(this).closest("tr").next(".fold").toggleClass("open");
        });

        var changeCategoryFunction = function(component) {
            if (component.attr('data-parent') == 0) //if parent element
                $("input[data-parent='" + component.val() + "']").prop('checked', component.is(":checked"));
            else if (component.is(":checked")) { //if child is checked, parent will be checked
                $("input[value='" + component.attr('data-parent') + "']").prop('checked', true);
            } else { //if all siblings are not checked, parent will remove check
                var siblings = $("input[data-parent='" + component.attr('data-parent') + "']");
                if (siblings.filter(":not(:checked)").length === siblings.length)
                    $("input[value='" + component.attr('data-parent') + "']").prop('checked', false);
            }

            var selectedCategories = [];

            $('input[name="category"]').each(function() {
                if ($(this).is(":checked")) {
                    var siblings = $("input[data-parent='" + $(this).attr('data-parent') + "']");
                    if ((siblings.filter(":checked").length !== siblings.length) || ($(this).attr(
                            'data-parent') == 0))
                        selectedCategories.push($(this));
                }
            });

            $(".category-badgets").html("");

            if (selectedCategories.length == 0)
                $(".clear-filters").hide();
            else
                $(".clear-filters").show();

            $(".inner-categories-tab>ul>li").removeClass("active");
            $.each(selectedCategories, function(index, value) {
                $(".category-badgets").append("<li value='" + value.val() + "'>" + value.next()
                    .text().trim() + "<span>x</span></li>");
                $(".inner-categories-tab>ul>li[value='" + value.val() + "']").addClass("active");
            });

            searchQuery = $('.music-search:visible').val();
            searchMusics(selectedCategories, searchQuery);
        };

        var searchMusics = function(selectedCategories = [], query = '', singer = '', favoriteOnly = false,
            allMusic = false) {
            $('#loadingIndicator').show(); // Show the loading indicator
            $.ajax({
                type: "POST",
                url: "<?php echo admin_url('admin-ajax.php'); ?>",
                data: {
                    action: "filter_products",
                    categories: JSON.stringify(selectedCategories.map(value => value.val())),
                    singer: singer,
                    query: query,
                    favorite_only: favoriteOnly,
                    all: allMusic
                },
                success: function(response) {
                    // Update the product list with the filtered products
                    $(".product-list").html(response);

                    setTimeout(function() {

                        $('audio').each(function() {
                            var audio = $(this)[0];
                            var playBarClip = $(this).parent().find(
                                '.play-bar');
                            var progressBarClip = $(this).parent().find(
                                '.progress-bar');
                            audio.addEventListener('timeupdate', function() {
                                var currentTime = audio.currentTime;
                                var duration = audio.duration;
                                var playBarWidth = 100 - (currentTime /
                                    duration) * 100;
                                var progressBarWidth = (currentTime /
                                    duration) * 100;

                                if (currentTime == duration) {
                                    playBarWidth = 100;
                                    progressBarWidth = 0;
                                    $(this).parent().find('.play-icon')
                                        .hide();
                                    $(this).parent().find('.play-btn')
                                        .show();
                                }
                                playBarClip.css('clip-path',
                                    'inset(0 ' + playBarWidth +
                                    '% 0 0)');
                                progressBarClip.css('clip-path',
                                    'inset(0 0 0 ' +
                                    progressBarWidth + '%)');
                            });
                        });
                    }, 1000);
                    $('#loadingIndicator').hide(); // Hide the loading indicator
                },
                error: function() {
                    console.log("Error Occured");
                    $('#loadingIndicator').hide(); // Hide the loading indicator
                }

            });
        };

        $(document).on("click", ".play-btn", function() {

            var gParent = $(this).parent().parent();
            $("div.product-list > div.row.audio-bg").each(function() {

                if ($(this).find(".play-icon").is(":visible")) {
                    $(this).find(".play-icon").click();
                }
                if ($(this).find('audio')[0].currentTime != 0) {
                    $(this).find('audio')[0].currentTime = 0;
                    $(this).find('.play-bar').css('clip-path', 'inset(0 100% 0 0)');
                    $(this).find('.progress-bar').css('clip-path', 'inset(0 0 0 0)');
                }
            });

            $(this).hide();
            $(this).parent().find('.play-icon').show();
            var audio = $(this).parent().parent().find('audio')[0];
            audio.play();
            intervalId = setInterval(() => {
                audio.currentTime += 1; // Increment the current time by 1 second
                audio.dispatchEvent(new Event('timeupdate'));
            }, 1000);
            $(this).parent().data('interval-id', intervalId);
        });

        $(document).on("click", ".play-icon", function() {
            $(this).hide();
            $(this).parent().find('.play-btn').show();
            var intervalId = $(this).parent().data('interval-id');
            clearInterval(intervalId);
            var audio = $(this).parent().parent().find('audio')[0];
            audio.pause();
        });

        $('.search-form').on('submit', function(event) {
            event.preventDefault(); // Prevent form submission
            var selectedCategories = [];

            $('input[name="category"]').each(function() {
                if ($(this).is(":checked")) {
                    var siblings = $("input[data-parent='" + $(this).attr('data-parent') +
                        "']");
                    if ((siblings.filter(":checked").length !== siblings.length) || ($(this)
                            .attr('data-parent') == 0))
                        selectedCategories.push($(this));
                }
            });

            var searchQuery = $('.music-search:visible').val(); // Get search query from input field
            searchMusics(selectedCategories, searchQuery);
        });

        searchMusics([], '', '', false, true);

        $(document).on("click", ".favorite-btn", function() {
            var postId = $(this).data('post-id');
            var favorite = $(this).data('favorite');
            var newFavorite = !favorite;

            $('#loadingIndicator').show(); // Show the loading indicator
            $.ajax({
                url: "<?php echo admin_url('admin-ajax.php'); ?>",
                type: 'POST',
                data: {
                    action: 'toggle_favorite',
                    post_id: postId,
                    favorite: newFavorite,
                },
                success: function(response) {
                    if (response.success) {
                        var button = $('div.btn.favorite-btn[data-post-id="' + postId +
                            '"]');
                        if (newFavorite) { //not favorite button will be desplayed
                            button.html(
                                '<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 512 512"><path d="M462.3 62.6C407.5 15.9 326 24.3 275.7 76.2L256 96.5l-19.7-20.3C186.1 24.3 104.5 15.9 49.7 62.6c-62.8 53.6-66.1 149.8-9.9 207.9l193.5 199.8c12.5 12.9 32.8 12.9 45.3 0l193.5-199.8c56.3-58.1 53-154.3-9.8-207.9" fill="#BF4261"/></svg>'
                            );

                        } else {
                            button.html( //favorite button
                                '<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 512 512"><path d="M225.8 468.2l-2.5-2.3L48.1 303.2C17.4 274.7 0 234.7 0 192.8v-3.3c0-70.4 50-130.8 119.2-144C158.6 37.9 198.9 47 231 69.6c9 6.4 17.4 13.8 25 22.3c4.2-4.8 8.7-9.2 13.5-13.3c3.7-3.2 7.5-6.2 11.5-9c0 0 0 0 0 0C313.1 47 353.4 37.9 392.8 45.4C462 58.6 512 119.1 512 189.5v3.3c0 41.9-17.4 81.9-48.1 110.4L288.7 465.9l-2.5 2.3c-8.2 7.6-19 11.9-30.2 11.9s-22-4.2-30.2-11.9zM239.1 145c-.4-.3-.7-.7-1-1.1l-17.8-20c0 0-.1-.1-.1-.1c0 0 0 0 0 0c-23.1-25.9-58-37.7-92-31.2C81.6 101.5 48 142.1 48 189.5v3.3c0 28.5 11.9 55.8 32.8 75.2L256 430.7 431.2 268c20.9-19.4 32.8-46.7 32.8-75.2v-3.3c0-47.3-33.6-88-80.1-96.9c-34-6.5-69 5.4-92 31.2c0 0 0 0-.1 .1s0 0-.1 .1l-17.8 20c-.3 .4-.7 .7-1 1.1c-4.5 4.5-10.6 7-16.9 7s-12.4-2.5-16.9-7z" fill="#F8F8F8" stroke="#F8F8F8" stroke-width="1.5"/></svg>'
                            );
							if ($("#favorite-tab").hasClass("active"))
                               button.parent().parent().parent().parent().remove();
                        }
                        button.attr('data-favorite', newFavorite ? "1" : "");
                    } else {
                        console.log('Failed to toggle favorite status');
                    }
                    $('#loadingIndicator').hide(); // Hide the loading indicator
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log('Error toggling favorite status: ' + textStatus + ', ' +
                        errorThrown);
                    $('#loadingIndicator').hide(); // Hide the loading indicator
                },
            });
        });


        $(document).on("click", ".btn.download-btn", function() {
            // e.preventDefault();
            var music_id = $(this).data('music-id');
            var file_url = $(this).data('file-url');
            var download_count = $(this).data('download-count');
            var credit_balance = $(this).data('credit-balance');
            if (credit_balance >= 1 && download_count < 5) {
                $('#loadingIndicator').show(); // Show the loading indicator
                // Send an AJAX request to the server to initiate the download
                $.ajax({
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    type: 'POST',
                    data: {
                        action: 'download_audio_file',
                        music_id: music_id,
                        file_url: file_url
                    },
                    success: function(response) {
                        // Handle the response from the server
                        if (response.success) {
                            var download_link = document.createElement('a');
                            download_link.href = window.URL.createObjectURL(new Blob([
                                response.data
                            ]));
                            download_link.download = file_url.substring(file_url
                                .lastIndexOf('/') + 1);
                            download_link.click();

                            $(this).data('download-count', download_count+1);
                            $('.btn.download-btn').data('credit-balance', credit_balance-1);

                            $("button.btn.credits").html((credit_balance-1)+"/40 CREDITS");
                            console.log('File downloaded successfully');
                        } else {
                            // Error downloading file
                            alert(response.data);
                            console.log('Error downloading file: ' + response.data);
                        }
                        $('#loadingIndicator').hide();
                    },
                    error: function(xhr, status, error) {
                        // Handle AJAX error
                        alert("An error occurred while downloading the file.");
                        console.log('AJAX error: ' + error);
                        $('#loadingIndicator').hide();
                    }
                });
            } else {
                alert("Insufficient credits or maximum download limit reached.");
            }
        });

        // $(document).on("click", ".btn.download-btn", function() {
        //     $('#loadingIndicator').show(); // Show the loading indicator
        //     $.ajax({
        //         url: "<?php echo admin_url('admin-ajax.php'); ?>",
        //         type: 'POST',
        //         data: {
        //             action: 'download_audio_file',
        //             file_url: $(this).find("a").attr("href"),
        //         },
        //         success: function() {

        //             $('#loadingIndicator').hide(); // Hide the loading indicator
        //         },
        //         error: function() {

        //             $('#loadingIndicator').hide(); // Hide the loading indicator
        //         },
        //     });
        // });

        $(document).on("click", "#browse-tab", function() {
            $(this).siblings().removeClass("active");
            $(this).addClass("active");
            var selectedCategories = [];

            $('input[name="category"]').each(function() {
                if ($(this).is(":checked")) {
                    var siblings = $("input[data-parent='" + $(this).attr('data-parent') +
                        "']");
                    if ((siblings.filter(":checked").length !== siblings.length) || ($(this)
                            .attr('data-parent') == 0))
                        selectedCategories.push($(this));
                }
            });

            var searchQuery = $('.music-search:visible').val(); // Get search query from input field
            if (selectedCategories.length === 0 && searchQuery === "")
                searchMusics([], '', '', false, true);
            else
                searchMusics(selectedCategories, searchQuery, '', false);
        });

        $(document).on("click", "#favorite-tab", function() {
            $(this).siblings().removeClass("active");
            $(this).addClass("active");

            $(this).siblings().removeClass("active");
            $(this).addClass("active");
            var selectedCategories = [];

            $('input[name="category"]').each(function() {
                if ($(this).is(":checked")) {
                    var siblings = $("input[data-parent='" + $(this).attr('data-parent') +
                        "']");
                    if ((siblings.filter(":checked").length !== siblings.length) || ($(this)
                            .attr('data-parent') == 0))
                        selectedCategories.push($(this));
                }
            });

            var searchQuery = $('.music-search:visible').val(); // Get search query from input field
            if (selectedCategories.length === 0 && searchQuery === "")
                searchMusics([], '', '', true, true);
            else
                searchMusics(selectedCategories, searchQuery, '', true);
        });
    });






    // var toggleFavorite = function (musicID) {
    //     $('#loadingIndicator').show(); // Show the loading indicator
    //     $.ajax({
    //         url: "<?php echo admin_url('admin-ajax.php'); ?>",
    //         type: 'POST',
    //         data: {
    //             action: 'toggle_wishlist',
    //             music_id: musicID
    //         },
    //         success: function (response) {
    //             if (response.success) {
    //                 // Product was added to the wishlist
    //                 alert('Product added to wishlist!');


    //             } else {
    //                 // Product was removed from the wishlist
    //                 alert('Product removed from wishlist!');

    //             }
    //             $("audio-"+musicID).parent().find("div.btn.favorite-btn > div >svg").toggle();
    //             $('#loadingIndicator').hide(); // Hide the loading indicator
    //         },
    //         error: function (xhr, status, error) {
    //             console.error(error);
    //             $('#loadingIndicator').hide(); // Hide the loading indicator
    //         }
    //     });
    // }
    </script>
</body>

</html>
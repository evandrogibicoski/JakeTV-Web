<script type="text/javascript">

function searcheddata(x)
{
    if(x == '1'){var method1 = 'index_searcheddata';}
    else if(x == '2'){var method1 = 'likes_searcheddata';}
    else{var method1 = 'bookmark_searcheddata';}
    
    var $data = $("#serachdata").val();
    $.get('service.php', {data: $data, action: 'search', method: method1}).done(function (data) {
        //$("#content123").html(data);
        if ($data == "") {
            if(x == '1'){
                $("#content123").show();
                $(".search_index_post").hide();
            }else if(x == '2'){
                $(".content123_likes").show();
                $(".search_likes_post").hide();
            }else{
                $(".content123_bookmark").show();
                $(".search_bookmark_post").hide();
            }
            
        } else {
            if (data == 2) {
                if(x == '1'){
                    var data1 = "<center class='notfound'><h2>No posts available.</h2></center>";
                    $('#select_category_post').html('');
					$(".search_index_post").show();
                    $(".search_index_post").html(data1);
                    $("#content123").hide();
                }else if(x == '2'){
                    var data1 = "<center class='notfound'><h2>No posts available.</h2></center>";
                    $('#select_category_post').html('');
					$(".search_likes_post").show();
                    $(".search_likes_post").html(data1);
                    $(".content123_likes").hide();
                }else{
                    var data1 = "<center class='notfound'><h2>No posts available.</h2></center>";
                    $('#select_category_post').html('');
					$(".search_bookmark_post").show();
                    $(".search_bookmark_post").html(data1);
                    $(".content123_bookmark").hide();
                }
                
            } else {
                if(x == '1'){
                    $('#select_category_post').html('');
					$(".search_index_post").show();
                    $(".search_index_post").html(data);
                    $("#content123").hide();
                }else if(x == '2'){
                    $('#select_category_post').html('');
					$(".search_likes_post").show();
                    $(".search_likes_post").html(data);
                    $(".content123_likes").hide();
                }else{
                    $('#select_category_post').html('');
					$(".search_bookmark_post").show();
                    $(".search_bookmark_post").html(data);
                    $(".content123_bookmark").hide();
                }
            }
        }
    });
}

function share_link(x){
    var postid = x;
    $.ajax({
        url: 'service.php',
        type: 'post',
        data: 'share_url=1&postid=' + postid,
        success: function (data)
        {
            var dd = "<a href='https://api.addthis.com/oexchange/0.8/forward/facebook/offer?url="+data+"&pubid=ra-567638a77cf41b9c&ct=1&title=Share%20Post&pco=tbxnj-1.0' target='_blank'><img src='https://cache.addthiscdn.com/icons/v2/thumbs/32x32/facebook.png' border='0' alt='Facebook'/></a>";
            var cc = "<a href='https://api.addthis.com/oexchange/0.8/forward/twitter/offer?url="+data+"&pubid=ra-567638a77cf41b9c&ct=1&title=Share%20Post&pco=tbxnj-1.0' target='_blank'><img src='https://cache.addthiscdn.com/icons/v2/thumbs/32x32/twitter.png' border='0' alt='Twitter'/></a>";
            
            document.getElementById('share_link').innerHTML = dd+cc;
            
//            if (data == 1) {
//                document.getElementById('errormsg').innerHTML = "<div class='alert alert-success' role='alert' style='font-size:16px;letter-spacing:1px;'>You data successfuly updated. Go to login page.</div>";
//            } else if (data == 0) {
//                document.getElementById('errormsg').innerHTML = "<div class='alert alert-danger' role='alert' style='font-size:16px;letter-spacing:1px;'>Your data not updated. Please try again.</div>";
//            } else {
//                document.getElementById('errormsg').innerHTML = "<div class='alert alert-danger' role='alert' style='font-size:16px;letter-spacing:1px;'>Your old password is wrong. Please enter right password.</div>";
//            }
        }
    });
}

    function login_page(x) {
        if (x == 1) {
            document.getElementById('login_page_value').value = "1";
        } else if (x == 2) {
            document.getElementById('login_page_value').value = "2";
        } else {
            document.getElementById('login_page_value').value = "3";
        }
    }

    function change_password1() {
        var password = $("#password").val();
        var newpass = $("#new_pass").val();
        var cnfrmpass = $("#cnfrm_pass").val();

        if (password == "") {
            document.getElementById("errormsg").innerHTML = "<div class='alert alert-danger' role='alert' style='font-size:16px;letter-spacing:1px;'>Please Enter Old Password.</div>";
            setTimeout(function () {
                document.getElementById("errormsg").innerHTML = '';
                document.getElementById('password').focus();
            }, 5000)
            return false;
        } else if (newpass == "") {
            ocument.getElementById("errormsg").innerHTML = "<div class='alert alert-danger' role='alert' style='font-size:16px;letter-spacing:1px;'>Please Enter new Password</div>";
            setTimeout(function () {
                document.getElementById("errormsg").innerHTML = '';
                document.getElementById('new_pass').focus();
            }, 5000)
            return false;
        } else if (cnfrmpass == "") {
            document.getElementById("errormsg").innerHTML = "<div class='alert alert-danger' role='alert' style='font-size:16px;letter-spacing:1px;'>Please Enter Confirm Password.</div>";
            setTimeout(function () {
                document.getElementById("errormsg").innerHTML = '';
                document.getElementById('cnfrm_pass').focus();
            }, 5000)
            return false;
        } else if (newpass != cnfrmpass) {
            document.getElementById("errormsg").innerHTML = "<div class='alert alert-danger' role='alert' style='font-size:16px;letter-spacing:1px;'>Password is not match with New Password.</div>";
            setTimeout(function () {
                document.getElementById("errormsg").innerHTML = '';
                document.getElementById('cnfrm_pass').focus();
            }, 5000)
            return false;
        } else {
            $.ajax({
                url: 'service.php',
                type: 'post',
                data: 'update_change_password=1&password=' + password + '&newpass=' + newpass,
                success: function (data)
                {
                    if (data == 1) {
                        document.getElementById('errormsg').innerHTML = "<div class='alert alert-success' role='alert' style='font-size:16px;letter-spacing:1px;'>You data successfuly updated. Go to login page.</div>";
                    } else if (data == 0) {
                        document.getElementById('errormsg').innerHTML = "<div class='alert alert-danger' role='alert' style='font-size:16px;letter-spacing:1px;'>Your data not updated. Please try again.</div>";
                    } else {
                        document.getElementById('errormsg').innerHTML = "<div class='alert alert-danger' role='alert' style='font-size:16px;letter-spacing:1px;'>Your old password is wrong. Please enter right password.</div>";
                    }
                }
            });
        }
    }

    function edit_register_join() {
        var f_name = document.getElementById('reg_f_name').value;
        var l_name = document.getElementById('reg_l_name').value;
        var email = document.getElementById('reg_email').value;
        if (f_name == "") {
            document.getElementById('reg_validation').innerHTML = "<div class='alert alert-danger' role='alert' style='font-size:16px;letter-spacing:1px;'>Enter First Name.</div>";
        }
        else if (l_name == "") {
            document.getElementById('reg_validation').innerHTML = "<div class='alert alert-danger' role='alert' style='font-size:16px;letter-spacing:1px;'>Enter Last Name.</div>";
        }
        else if (email == "") {
            document.getElementById('reg_validation').innerHTML = "<div class='alert alert-danger' role='alert' style='font-size:16px;letter-spacing:1px;'>Enter Email Id.</div>";
        }
        else {
            $.ajax({
                url: 'service.php',
                type: 'post',
                data: 'update_register=1&f_name=' + f_name + '&l_name=' + l_name + '&email=' + email,
                success: function (data)
                {
                    if (data == 1) {
                        document.getElementById('reg_validation').innerHTML = "<div class='alert alert-success' role='alert' style='font-size:16px;letter-spacing:1px;'>You data successfuly updated. Go to login page.</div>";
                    } else {
                        document.getElementById('reg_validation').innerHTML = "<div class='alert alert-danger' role='alert' style='font-size:16px;letter-spacing:1px;'>Your data not updated. Please try again.</div>";
                    }
                }
            });
        }
    }


//    function likes_searcheddata()
//    {
//        var $data = $("#serachdata").val();
//        $.get('service.php', {data: $data, action: 'likes_search'}).done(function (data) {
//            if ($data == "") {
//                $(".content123_likes").show();
//                $(".search_likes_post").hide();
//            } else {
//                if (data == 2) {
//                    var data1 = "<center style='margin-top:20px; color:#F26943;'><h1>Sorry, no found any post related your result.</h1></center>";
//                    $(".search_likes_post").show();
//                    $(".search_likes_post").html(data1);
//                    $(".content123_likes").hide();
//                } else {
//                    $(".search_likes_post").show();
//                    $(".search_likes_post").html(data);
//                    $(".content123_likes").hide();
//
//                }
//            }
//        });
//    }
//
//    function bookmark_searcheddata()
//    {
//        var $data = $("#serachdata").val();
//        $.get('service.php', {data: $data, action: 'bookmark_search'}).done(function (data) {
//            if ($data == "") {
//                $(".content123_bookmark").show();
//                $(".search_bookmark_post").hide();
//            } else {
//                if (data == 2) {
//                    var data1 = "<center style='margin-top:20px; color:#F26943;'><h1>Sorry, no found any post related your result.</h1></center>";
//                    $(".search_bookmark_post").show();
//                    $(".search_bookmark_post").html(data1);
//                    $(".content123_bookmark").hide();
//                } else {
//                    $(".search_bookmark_post").show();
//                    $(".search_bookmark_post").html(data);
//                    $(".content123_bookmark").hide();
//
//                }
//            }
//        });
//    }

    function Cat_Post_List(x) {
        var catid = x;

        //window.location.href = "cat_post_list.php?cat_post_list="+catid+"&catid="+catid;

        $.ajax({
            url: 'service.php',
            type: 'post',
            data: 'cat_post_list=1&catid=' + catid,
            success: function (data)
            {
                if (data == 2) {
                    var data1 = "<center class='notfound'><h2>Category not available.</h2></center>";
					$('#select_category_post').html('');
                    $('#select_category_post').append(data1);
                } else {
                    $('#content123').hide();
                    $('#select_category_post').html('');
                    $('#select_category_post').append(data);
                }
            }
        });
    }

    function load_script_data(x, y) {
        var div_id = "#new_div";
        if (x == undefined) {
            var dd = document.getElementById('load_value_hidden').value++;
            var dc = dd;
        } else {
            var dd = document.getElementById('load_value_hidden').value++;
            var dc = dd;
        }

        var PageLimit = 24;
        var Offset = dc * PageLimit;
        var pagedata = (dc + 1) * PageLimit;

        if (y > pagedata) {alert('1');
            $.ajax({
                url: 'service.php',
                type: 'post',
                data: 'load_value_data=' + dc,
                success: function (data)
                {
                    if (data == 2) {
                        $('#load_more').hide();
                    } else {
                        $(div_id).append(data);
                    }
                }
            });
        } else {
            $.ajax({
                url: 'service.php',
                type: 'post',
                data: 'load_value_data=' + dc,
                success: function (data)
                {
                    if (data == 2) {
                        $('#load_more').hide();
                    } else {
                        $(div_id).append(data);
                        $('#load_more').hide();
                    }
                }
            });
        }
    }

    function load_like_page1(x, y) {
        var div_id1 = "#likes_new_div";
        if (x == undefined) {
            var dd = document.getElementById('load_value_hidden').value++;
            var dc = dd;
        } else {
            var dd = document.getElementById('load_value_hidden').value++;
            var dc = dd;
        }

        var PageLimit = 24;
        var Offset = dc * PageLimit;
        var pagedata = (dc + 1) * PageLimit;

        if (y > pagedata) {
            $.ajax({
                url: 'service.php',
                type: 'post',
                data: 'likes_load_value_data=' + dc,
                success: function (data)
                {
                    if (data == 2) {
                        $('#load_more').hide();
                    } else {
                        $(div_id1).append(data);
                    }
                }
            });
        } else {
            $.ajax({
                url: 'service.php',
                type: 'post',
                data: 'likes_load_value_data=' + dc,
                success: function (data)
                {
                    if (data == 2) {
                        $('#load_more').hide();
                    } else {
                        $(div_id1).append(data);
                        $('#load_more').hide();
                    }
                }
            });
        }
    }

    function load_bookmark_page1(x, y) {
        var div_id1 = "#bookmark_new_div";
        if (x == undefined) {
            var dd = document.getElementById('load_value_hidden').value++;
            var dc = dd;
        } else {
            var dd = document.getElementById('load_value_hidden').value++;
            var dc = dd;
        }

        var PageLimit = 24;
        var Offset = dc * PageLimit;
        var pagedata = (dc + 1) * PageLimit;

        if (y > pagedata) {
            $.ajax({
                url: 'service.php',
                type: 'post',
                data: 'bookmark_load_value_data=' + dc,
                success: function (data)
                {
                    if (data == 2) {
                        $('#load_more').hide();
                    } else {
                        $(div_id1).append(data);
                    }
                }
            });
        } else {
            $.ajax({
                url: 'service.php',
                type: 'post',
                data: 'bookmark_load_value_data=' + dc,
                success: function (data)
                {
                    if (data == 2) {
                        $('#load_more').hide();
                    } else {
                        $(div_id1).append(data);
                        $('#load_more').hide();
                    }
                }
            });
        }


    }


    /*function load_script(){
     var count = 1;
     var dd = document.getElementById('load_value_hidden').value++;
     var dc = dd+1;
     //document.getElementById('load_value_hidden').innerHTML = dd.value;
     $.ajax({
     url : 'index.php', 
     type : 'post',
     data: 'load_value='+dc,				
     success : function(data) 
     {
     window.location.reload();
     }	
     });
     }*/


    function load_like_page() {
        var count = 1;
        var dd = document.getElementById('load_value_hidden').value++;
        var dc = dd + 1;
        $.ajax({
            url: 'likes.php',
            type: 'post',
            data: 'load_value=' + dc,
            success: function (data)
            {
                window.location.reload();
            }
        });
    }
    function load_bookmark_page() {
        var count = 1;
        var dd = document.getElementById('load_value_hidden').value++;
        var dc = dd + 1;
        $.ajax({
            url: 'bookmark.php',
            type: 'post',
            data: 'load_value=' + dc,
            success: function (data)
            {
                window.location.reload();
            }
        });
    }
    function see_more(x) {
        id = "#desc" + x;
        id1 = "#desc1" + x;
        $(id).hide();
        $('#seemore' + x).hide();
        $(id1).show();
        $('#back' + x).show();
    }
    function back(x) {
        $(id1).hide();
        $('#back' + x).hide();
        $(id).show();
        $('#seemore' + x).show();
    }

    function register_join() {
        var f_name = document.getElementById('reg_f_name').value;
        var l_name = document.getElementById('reg_l_name').value;
        var email = document.getElementById('reg_email').value;
        var password = document.getElementById('reg_password').value;
        var c_password = document.getElementById('reg_c_password').value;

        if (f_name == "") {
            document.getElementById('reg_validation').innerHTML = "<div class='alert alert-danger' role='alert' style='font-size:16px;letter-spacing:1px;'>Please Enter First Name.</div>";
        }
        else if (l_name == "") {
            document.getElementById('reg_validation').innerHTML = "<div class='alert alert-danger' role='alert' style='font-size:16px;letter-spacing:1px;'>Please Enter Last Name.</div>";
        }
        else if (email == "") {
            document.getElementById('reg_validation').innerHTML = "<div class='alert alert-danger' role='alert' style='font-size:16px;letter-spacing:1px;'>Please Enter Email.</div>";
        }
        else if (password == "") {
            document.getElementById('reg_validation').innerHTML = "<div class='alert alert-danger' role='alert' style='font-size:16px;letter-spacing:1px;'>Please Enter Password.</div>";
        }
        else if (c_password != password) {
            document.getElementById('reg_validation').innerHTML = "<div class='alert alert-danger' role='alert' style='font-size:16px;letter-spacing:1px;'>Please Enter Valid Password.</div>";
        }
        else {
            $.ajax({
                url: 'service.php',
                type: 'post',
                data: 'register=1&f_name=' + f_name + '&l_name=' + l_name + '&email=' + email + '&password=' + password + '&c_password=' + c_password,
                success: function (data)
                {
                    if (data == '1') {
                        document.getElementById('reg_validation').innerHTML = "<div class='alert alert-danger' role='alert' style='font-size:16px;letter-spacing:1px;'>You Are Successfully Registered.</div>";
                    } else if (data == '0') {
                        document.getElementById('reg_validation').innerHTML = "<div class='alert alert-danger' role='alert' style='font-size:16px;letter-spacing:1px;'>Please Try Again..</div>";
                    } else {
                        document.getElementById('reg_validation').innerHTML = "<div class='alert alert-danger' role='alert' style='font-size:16px;letter-spacing:1px;'>Emai id Already Registered.</div>";
                    }
                }
            });
        }
    }
    function login_user() {
        var email = document.getElementById('login_email').value;
        var password = document.getElementById('login_pass').value;
        var login_page = document.getElementById('login_page_value').value;

        if (email == "") {
            document.getElementById('login_validation').innerHTML = "<div class='alert alert-danger' role='alert' style='font-size:16px;letter-spacing:1px;'>Please Enter Email.</div>";
        } else if (password == "") {
            document.getElementById('login_validation').innerHTML = "<div class='alert alert-danger' role='alert' style='font-size:16px;letter-spacing:1px;'>Please Enter Password.</div>";
        } else {
            $.ajax({
                url: 'service.php',
                type: 'post',
                data: 'login=1&email=' + email + '&password=' + password,
                success: function (data)
                {
                    if (data == '1') {
                        if (login_page == 1) {
                            window.location.href = "likes.php";
                        } else if (login_page == 2) {
                            window.location.href = "bookmark.php";
                        } else if (login_page == 3) {
                            window.location.href = "category.php";
                        } else {
                            window.location.href = "index.php";
                        }
                    } else if (data == '2') {
                        document.getElementById('login_validation').innerHTML = "<div class='alert alert-danger' role='alert' style='font-size:16px;letter-spacing:1px;'>Please Try Agin.</div>";
                    } else {
                        document.getElementById('login_validation').innerHTML = "<div class='alert alert-danger' role='alert' style='font-size:16px;letter-spacing:1px;'>Please Enter Valid Email or Password.</div>";
                    }
                }
            });
        }
    }
    function like_post(x) {
        var postid = x;
        $.ajax({
            url: 'service.php',
            type: 'post',
            data: 'like_post=1&postid=' + postid,
            success: function (data)
            {
                if (data == '1') {
                    var p1 = ".like_post1" + x;
                    var p = ".like_post" + x;
                    $(p1).hide();
                    $(p).show();
                } else if (data == '2') {
                    alert('you have problem in login');
                } else {
                    alert('please like again');
                }
            }
        });

    }
    function unlike_post(x) {
        var postid = x;
        $.ajax({
            url: 'service.php',
            type: 'post',
            data: 'unlike_post=1&postid=' + postid,
            success: function (data)
            {
                if (data == '1') {
                    var p1 = ".like_post1" + x;
                    var p = ".like_post" + x;
                    $(p).hide();
                    $(p1).show();
                } else if (data == '2') {
                    alert('you have problem in login');
                } else {
                    alert('please like again');
                }
            }
        });

    }
    function bookmark_post(x) {
        var postid = x;
        $.ajax({
            url: 'service.php',
            type: 'post',
            data: 'bookmark_post=1&postid=' + postid,
            success: function (data)
            {
                if (data == '1') {
                    var b1 = ".bookmark_post1" + x;
                    var b = ".bookmark_post" + x;
                    $(b1).hide();
                    $(b).show();
                } else if (data == '2') {
                    alert('you have problem in login');
                } else {
                    alert('please bookmark again');
                }
            }
        });

    }
    function unbookmark_post(x) {
        var postid = x;
        $.ajax({
            url: 'service.php',
            type: 'post',
            data: 'unbookmark_post=1&postid=' + postid,
            success: function (data)
            {
                if (data == '1') {
                    var b1 = ".bookmark_post1" + x;
                    var b = ".bookmark_post" + x;
                    $(b).hide();
                    $(b1).show();
                } else if (data == '2') {
                    alert('you have problem in login');
                } else {
                    alert('please bookmark again');
                }
            }
        });

    }
    /* ----------Likes----------- */
    function unlike_post_likes(x) {
        var postid = x;
        $.ajax({
            url: 'service.php',
            type: 'post',
            data: 'unlike_post=1&postid=' + postid,
            success: function (data)
            {
                if (data == '1') {
                    window.location.reload();
                } else if (data == '2') {
                    alert('you have problem in login');
                } else {
                    alert('please like again');
                }
            }
        });

    }
    /* ---------bookmark--------- */
    function unbookmark_post_bookmark(x) {
        var postid = x;
        $.ajax({
            url: 'service.php',
            type: 'post',
            data: 'unbookmark_post=1&postid=' + postid,
            success: function (data)
            {
                if (data == '1') {
                    window.location.reload();
                } else if (data == '2') {
                    alert('you have problem in login');
                } else {
                    alert('please bookmark again');
                }
            }
        });

    }
    /* ----------Category---------- */
    function user_cat_click(x) {
        var cat_id = x;
        $.ajax({
            url: 'service.php',
            type: 'post',
            data: 'UserSelectCategory=1&cat_id=' + cat_id,
            success: function (data)
            {
                if (data == 1) {
                    var cat_id = ".cat_id" + x;
                    var cat_id1 = ".cat_id1" + x;

                    $(cat_id).hide();
                    $(cat_id1).show();
                } else if (data == 2) {
                    alert('you have problem in login');
                } else {
                    alert('please check again');
                }
            }
        });
    }

    function unset_user_cat_click(x) {
        var cat_id = x;
        $.ajax({
            url: 'service.php',
            type: 'post',
            data: 'UnsetUserSelectCategory=1&cat_id=' + cat_id,
            success: function (data)
            {
                if (data == 1) {
                    var cat_id = ".cat_id" + x;
                    var cat_id1 = ".cat_id1" + x;

                    $(cat_id1).hide();
                    $(cat_id).show();
                } else if (data == 2) {
                    alert('you have problem in login');
                } else {
                    alert('please check again');
                }
            }
        });
    }
</script>
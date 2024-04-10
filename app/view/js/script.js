$(document).ready(function () {
  var offset = 5;
  var limit = 3;
  function fetchPosts() {
    $.ajax({
      url: "/fetch",
      method: "POST",
      data: {
        offset: offset,
        limit: limit,
      },
      success: function (response) {
        if (response !== "") {
          $("#postsContainer").append(response);
          offset += limit;
        } else {
          $("#loadMore").prop("disabled", true).text("no more posts");
        }
      },
      error: function (status, error) {
        console.error(status);
        console.error(error);
      },
    });
  }
  $("#postsContainer").on("click", ".like_button", function () {
    var post_id = $(this).data("post-id");
    console.log(post_id);
    $.ajax({
      url: "/like",
      type: "POST",
      data: {
        post_id: post_id,
      },
      success: function () {
        window.location.href ="/home";
      },
      error: function (error) {
        console.error(error);
      },
    });
  });
  $("#loadMore").on("click", fetchPosts);

  $("#getOtp").click(function() {
    let email = $('#email').val();
    if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) {
      $.ajax({
        url: "controller/login_control/otp.php",
        type: "POST",
        data: {
          email: email
        },
        success: function(response) {
          alert("OTP is Sent. Check your mail  !!");
        },  
      });
    }
    else {
      alert("Invalid email format !!");
    }
  });
});

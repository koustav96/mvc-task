$(document).ready(function () {
  var offset = 5;
  var limit = 3;
  $("#loadMore").on("click", fetchPosts);
  /**
   * A function to fetch next three posts whenever user clicks on load more button.
   */
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
          // Appending next posts with the previous posts.
          $("#postsContainer").append(response);
          offset += limit;
        } 
        else {
          $("#loadMore").prop("disabled", true).text("no more posts");
        }
      },
    });
  }

  /**
   * A function to update the likes or dislikes.
   */
  $("#postsContainer").on("click", ".like_button", function () {
    var post_id = $(this).data("post-id");
    console.log(post_id);
    $.ajax({
      url: "/like",
      type: "POST",
      data: {
        'post_id': post_id,
      },
      success: function () {
        window.location.href ="/home";
      },
    });
  });
  /**
   * A function to generate otp when the get otp button is hit.
   */
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
          $('#warning').text("OTP is Sent. Check your mail !!");
        },  
      });
    }
    else {
      $('#warning').text("Invalid email format !!");
    }
  });
});

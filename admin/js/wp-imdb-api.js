jQuery(document).ready(function($){
  $('.imdbapi_tab li a').click(function(){
    $('.imdbapi_tab li').removeClass('imdbapi_active');
    $(this).parent().addClass('imdbapi_active');
    var href = $(this).attr('href');
    $('.imdbapi_tab_element').hide();
    $(href).show();
    return false;
  });
  var tempResult = null;
  var tempID = null;
  var imdbID = null;


  /**
   * display warning message for once.
   */


  if( $("#imdbapi-metabox-id-value").val() != '' ){
    $(".imdbapi-metabox-slide1").hide();
    $(".imdbapi-tab-wrapper").show("fast");
    $(".imdbapi-metabox-common-fields").show("fast");
  }

  /*
   *	Fixes #6
   * Tabs on Dashboard Backend WordPress is Unclickable
   */

  $(".imdbapi-tab1").click(function(e){
    e.preventDefault();
  });

  $(".imdbapi-tab2").click(function(e){
    e.preventDefault();
  });

  $(".crawler-error-btn").live("click", function(e){
    $(".crawler-error").fadeOut("fast");
    $(".imdbapi-metabox-slide2").fadeIn("fast");
    e.preventDefault();
  });

  $("#imdbapi-bytitle").click(function(){

    $(".imdbapi-metabox-slide1").hide();
    $(".imdbapi-metabox-slide2").show();
  });


  $("#imdbapi-byid").click(function(){

    $(".imdbapi-metabox-slide1").hide();
    $(".imdbapi-metabox-slide3").show();
  });


  $("#imdbapi_goto1").click(function(e){
    $(".imdbapi-metabox-slide2").hide();
    $(".imdbapi-metabox-slide1").show();
    e.preventDefault();
  });

  $("#imdbapi_goto2").click(function(e){
    $(".imdbapi-metabox-slide3").hide();
    $(".imdbapi-metabox-slide1").show();
    e.preventDefault();
  });

  $(".imdbapi-try-btn").live("click", function(e){
    $(".imdbapi-metabox-slide4").hide();
    $(".imdbapi-metabox-slide2").show();
    e.preventDefault();
  });
  $(".imdbapi-alt-api").live("click", function(e){
    $(".imdbapi-metabox-slide4").fadeOut("fast");
    $(".imdbapi-metabox-loader").fadeIn("fast");
    $.ajax({
      type: "POST",
      url: document.URL,
      data:{
        'imdbID': imdbID,
      },
      success: function(html){
        $(".imdbapi-metabox-loader").fadeOut("fast");
        $(".imdbapi-metabox-slide4 .inside").html(html);
        $(".imdbapi-metabox-slide4").fadeIn("fast");
      }
    })
    e.preventDefault();
  });

  $(".imdbapi-result-result-link").live("click",function(e){
    imdbID = $(this).attr("title");
    if(tempID == imdbID){
      $(".imdbapi-result-temp-results").hide();
      $(".imdbapi-metabox-slide4").show();
    }
    else{
      tempID = $(this).attr("title");
      $(".imdbapi-result-search-results").fadeOut("fast");
      $(".imdbapi-metabox-loader").fadeIn("fast");
      $.ajax({
        type: "POST",
        url:  document.URL,
        data: {
          'imdbID':imdbID,
        },

        success: function(html){
          $(".imdbapi-metabox-loader").fadeOut("fast");
          $(".imdbapi-metabox-slide4 .inside").html(html);
          $(".imdbapi-metabox-slide4").fadeIn("fast");
        }
      }) //End ajax

      $("#imdbapi_back2").live("click", function(e){
        $(".imdbapi-metabox-slide4").hide();
        $(".imdbapi-result-temp-results").show();
        e.preventDefault();
      });

      $("#imdbapi_back1").live("click",function(e){
        $(".imdbapi-metabox-slide4").hide();
        $(".imdbapi-result-temp-results").hide();
        $(".imdbapi-metabox-slide2").show();
        e.preventDefault();
      });
    }
    e.preventDefault();
  });

  $("#imdbapi-search-submit").live("click", function(){

    var target = document.URL;
    var query = $("#imdbapi-query").val();
    var year = $("#imdbapi-year").val();

    if(query == ''){
      $(".imdbapi-empty-title").fadeIn("fast").delay(1500).fadeOut("fast");
    }
    else{

      $(".imdbapi-metabox-slide2").fadeOut("fast");
      $(".imdbapi-metabox-loader").fadeIn("fast");

      $.ajax({

        type: "POST",
        url:  target,
        data: {
          'imdbQuery':query,
          'imdbYear':year,
        },

        success: function(html){
          $(".imdbapi-metabox-loader").fadeOut("fast");
          $(".imdbapi-metabox-slide4 .inside").html(html);
          $(".imdbapi-metabox-slide4").fadeIn("fast");

          $("#imdbapi_back1").on("click", function(e){
            $(".imdbapi-metabox-slide4").hide();
            $(".imdbapi-metabox-slide2").show();
            e.preventDefault();
          });

          tempResult = $(".imdbapi-result-search-results").html();
          $(".imdbapi-result-temp-results").addClass("imdbapi-result-search-results");
          $(".imdbapi-result-temp-results").html(tempResult);
        }
      })
    }

  }); //End imdbapi-search-submit

  $("#imdbapi-id-submit").click(function(){
    var target = document.URL;
    var imdbID = $("#imdbapi-id").val();
    var pattern = /tt(\d)/;

    if(imdbID == ''){
      $(".imdbapi-empty-id").fadeIn("fast").delay(1500).fadeOut("fast");
    }
    else if(!pattern.test(imdbID)){
      $(".imdbapi-invalid-id").fadeIn("fast").delay(1500).fadeOut("fast");
    }
    else{

      $(".imdbapi-metabox-slide3").fadeOut('fast');
      $(".imdbapi-metabox-loader").fadeIn('fast');

      $.ajax({
        type: "POST",
        url:target,
        data: {

          'imdbID':imdbID,
        },
        success: function(html){
          $(".imdbapi-metabox-loader").fadeOut('fast');
          $(".imdbapi-metabox-slide4 .inside").html(html);
          $('.imdbapi-metabox-slide4').fadeIn('fast');

          $("#imdbapi_back2").click(function(e){
            $(".imdbapi-metabox-slide4").hide();
            $(".imdbapi-metabox-slide3").show();
            e.preventDefault();
          });

        }

      });
    }
  });

  // pretend to submiting information

  $(".imdbapi-submit-info").live("click", function(){

    var target = document.URL;

    $(".imdbapi-result-search-results").fadeOut("fast");

    $(".imdbapi-metabox-loader").fadeIn("fast");

    /**
     * so when user confirm this results, next step is saving poster
     *
     */

    if($("#imdbapi-crawler-poster").text() !== "N/A"){

      var poster = $("#imdbapi-crawler-poster").text();

      //alert(poster);

      $.ajax({
        type: "POST",
        url:target,
        data: {
          'poster_url':poster,
        },
        success: function(response){
          $("textarea[name=imdbapi-poster-value]").text(response);

          $(".imdbapi-tab-wrapper").fadeIn("fast");
          $(".imdbapi-metabox-common-fields").fadeIn("fast");

          $(".imdbapi-metabox-loader").fadeOut("fast");
        }

      });

    }
    else{

      $("textarea[name=imdbapi-poster-value]").text($("#imdbapi-crawler-poster").text());

    }


    /**
     * Pasting results into metabox fields
     * Section: common fields
     */

    $("input[name=imdbapi-genre-value]").val($("#imdbapi-crawler-genre").text());
    $("input[name=imdbapi-country-value]").val($("#imdbapi-crawler-country").text());
    $("input[name=imdbapi-language-value]").val($("#imdbapi-crawler-language").text());
    $("textarea[name=imdbapi-plot-value]").text($("#imdbapi-crawler-plot").text());



    /**
     * Pasting results into metabox fields
     * Section: other fields
     */


    $("input[name=imdbapi-rated-value]").val($("#imdbapi-crawler-rated").text());
    $("input[name=imdbapi-released-value]").val($("#imdbapi-crawler-released").text());
    $("input[name=imdbapi-runtime-value]").val($("#imdbapi-crawler-runtime").text());
    $("input[name=imdbapi-director-value]").val($("#imdbapi-crawler-director").text());
    $("input[name=imdbapi-writer-value]").val($("#imdbapi-crawler-writer").text());
    $("input[name=imdbapi-actors-value]").val($("#imdbapi-crawler-actors").text());
    $("input[name=imdbapi-metascore-value]").val($("#imdbapi-crawler-metascore").text());
    $("input[name=imdbapi-imdbrating-value]").val($("#imdbapi-crawler-imdbrating").text());
    $("input[name=imdbapi-imdbvotes-value]").val($("#imdbapi-crawler-imdbvotes").text());
    $("input[name=imdbapi-gross-value]").val($("#imdbapi-crawler-gross").text());
    $("input[name=imdbapi-budget-value]").val($("#imdbapi-crawler-budget").text());

    /**
     * these fields are not editable and hidden from user view.
     */

    $("input[name=imdbapi-id-value]").val($("#imdbapi-crawler-imdbapid").text());
    $("input[name=imdbapi-title-value]").val($("#imdbapi-crawler-title").text());
    $("input[name=imdbapi-year-value]").val($("#imdbapi-crawler-year").text());
    $("input[name=imdbapi-type-value]").val($("#imdbapi-crawler-type").text());

    $(".imdbapi-tab-wrapper").fadeIn("fast");
    $(".imdbapi-metabox-common-fields").fadeIn("fast");

    $(".imdbapi-metabox-loader").fadeOut("fast").delay(1500);


    /**
     * Clearing search track to prevent crashing.
     */

    $("#imdbapi-query").val("");
    $("#imdbapi-year").val("");
    $("#imdbapi-id").val("");

  });

  // switch between tabs

  $(".imdbapi-tab1").on("click", function(){
    $(".imdbapi-tab2").removeClass("nav-tab-active");
    $(".imdbapi-tab1").addClass("nav-tab-active");
    $(".imdbapi-metabox-common-fields").fadeIn("fast");
    $(".imdbapi-metabox-other-fields").fadeOut("fast");
  });

  $(".imdbapi-tab2").on("click", function(){
    $(".imdbapi-tab1").removeClass("nav-tab-active");
    $(".imdbapi-tab2").addClass("nav-tab-active");
    $(".imdbapi-metabox-other-fields").fadeIn("fast");
    $(".imdbapi-metabox-common-fields").fadeOut("fast");
  });


  $("#imdbapi-query").keypress(function (e) {
    if (e.which == '13') {
      e.preventDefault();
      $("#imdbapi-search-submit").click();
    }
  });

  $("#imdbapi-id").keypress(function (e) {
    if (e.which == '13') {
      e.preventDefault();
      $("#imdbapi-id-submit").click();
    }
  });
});
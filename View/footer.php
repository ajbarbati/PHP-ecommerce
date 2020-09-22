<nav class="footer" style='text-align: center;'>
  <a class="footer-link" href="https://fortisureit.com/">FortisureIT</a>
  <a class="footer-link" href="https://food.fortisureit.com/">Food Partners</a>
</nav>
</div>
<script>
   // Saving Scroll Position
    /* How To Add To Any Page By Button Click:
        onclick='scrollSave.scroll()' */

    // define container
    var scrollSave = {};

    // append scroll parameter to URL or return scroll value
    scrollSave.scroll = function (url) {
      // DOM compliant
      if (document.body && document.body.scrollTop) {
        scroll = document.body.scrollTop;
        AjaxScroll(scroll);
      }
      // old - Netscape compliant
      else if (typeof (window.pageYOffset) === 'number') {
        scroll = window.pageYOffset;
        AjaxScroll(scroll);
      }
      // when vertical scroll bar is on the top
      else {
        scroll = 0;
      }
      // if input parameter does not exist then return scroll value
      if (url === undefined) {
        return scroll;
      }
      // else append scroll parameter to URL
      else {
        // set "?" or "&" before scroll parameter
        q = url.indexOf('?') === -1 ? '?' : '&';
        // load page with scroll position parameter
        window.location.href = url + q + 'scroll=' + scroll;
      }
    };

    // set scroll position if URL contains scroll=nnn parameter
    scrollSave.setScrollOnLoad = function () {
      <?php // if (isset($_SESSION['scrollSet'])){echo strval($_SESSION['scrollSet']);} else {return 500;}; ?>
      var scrollPos = "<?php echo strval($_SESSION['scrollSet']) ?>"
      window.scrollTo(0, scrollPos);

      // get query string parameter with "?"
      let search = window.location.search,
        matches;
      // if query string exists
      if (search) {
        // find scroll parameter in query string
        matches = /scroll=(\d+)/.exec(search);

        // jump to scroll position if scroll parameter exists
        if (matches) {
          window.scrollTo(0, matches[1]);
        }
      }
    };

    // add onload event listener
    if (window.addEventListener) {
      window.addEventListener('load', scrollSave.setScrollOnLoad, false);
    }
    else if (window.attachEvent) {
      window.attachEvent('onload', scrollSave.setScrollOnLoad);
    }

    function AjaxScroll($data) {
      $.ajax({ 
        url: '../Controller/ajaxScroll.php', //where the data gets sent to
        data: {
            scroll: $data // the data -- NAME = cartItem VALUE = $data
        },
        type: 'GET'
      });
    }



    
  /* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
  function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
  }

  // Close the dropdown if the user clicks outside of it
  window.onclick = function(event) {
    if (!event.target.matches('.dropbtn')) {
      var dropdowns = document.getElementsByClassName("dropdown-content");
      var i;
      for (i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i];
        if (openDropdown.classList.contains('show')) {
          openDropdown.classList.remove('show');
        }
      }
      window.scrollTo(0, 50); // values are x,y-offset
    }
  }
</script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://js.stripe.com/v2/"></script>
<script src="https://js.stripe.com/v3/"></script>
<script src="View/Public/js/charge.js"></script>
<script type='text/javascript' src='View/Public/JS/modal.js'></script>

</body>

</html>
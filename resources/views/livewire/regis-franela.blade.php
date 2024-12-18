<div>

<style>
    #card1{
      display:block;
    }
    #card2, #card3 {
      display: none;
    }
    </style>
  <select name="" id="slct" onchange="showOnChange(event)">
    <option value="card1">card1</option>
    <option value="card2">card2</option>
    <option value="card3">card3</option>
  </select>
  <div id="card1">card1</div>
  <div id="card2">card2</div>
  <div id="card3">card3</div>

  <script>
    function showOnChange(e) {
      var elem = document.getElementById("slct");
      var value = elem.options[elem.selectedIndex].value;
      if(value == "card1")
        {
          document.getElementById('card1').style.display = "block";
          document.getElementById('card2').style.display = "none";
          document.getElementById('card3').style.display = "none";
        }
     else if(value == "card2")
       {
            document.getElementById('card1').style.display = "none";
            document.getElementById('card2').style.display = "block";
            document.getElementById('card3').style.display = "none";
       }
     else if(value == "card3")
       {
          document.getElementById('card1').style.display = "none";
          document.getElementById('card2').style.display = "none";
          document.getElementById('card3').style.display = "block";
       }

    }
  </script>

</div>

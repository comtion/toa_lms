
        document.getElementById("moderntrade").checked = true;
        document.getElementById("modern_all").checked = true;
        document.getElementById("mo_1").checked = true;
        document.getElementById("mo_2").checked = true;
        document.getElementById("mo_3").checked = true;
        document.getElementById("mo_4").checked = true;
        document.getElementById("mo_po1").checked = true;
        document.getElementById("mo_po2").checked = true;
        document.getElementById("mo_po3").checked = true;
        document.getElementById("mo_po4").checked = true;
        document.getElementById("mo_po5").checked = true;
        document.getElementById("mo_po6").checked = true;
        document.getElementById("mo_po7").checked = true;
        document.getElementById("mo_po8").checked = true;
        document.getElementById("mo_po9").checked = true;
        document.getElementById("mo_po10").checked = true;
        document.getElementById("mo_po11").checked = true;
        document.getElementById("mo_po12").checked = true;
        document.getElementById("mo_po13").checked = true;
        document.getElementById("mo_po14").checked = true;
        document.getElementById("mo_po15").checked = true;
        document.getElementById("mo_po16").checked = true;

        const checkbox = document.getElementById('modern_all')

        checkbox.addEventListener('change', (event) => {
          if (event.target.checked) {
            document.getElementById("moderntrade").checked = true;
            document.getElementById("mo_1").checked = true;
            document.getElementById("mo_2").checked = true;
            document.getElementById("mo_3").checked = true;
            document.getElementById("mo_4").checked = true;
            document.getElementById("mo_po1").checked = true;
            document.getElementById("mo_po2").checked = true;
            document.getElementById("mo_po3").checked = true;
            document.getElementById("mo_po4").checked = true;
            document.getElementById("mo_po5").checked = true;
            document.getElementById("mo_po6").checked = true;
            document.getElementById("mo_po7").checked = true;
            document.getElementById("mo_po8").checked = true;
            document.getElementById("mo_po9").checked = true;
            document.getElementById("mo_po10").checked = true;
            document.getElementById("mo_po11").checked = true;
            document.getElementById("mo_po12").checked = true;
            document.getElementById("mo_po13").checked = true;
            document.getElementById("mo_po14").checked = true;
            document.getElementById("mo_po15").checked = true;
            document.getElementById("mo_po16").checked = true;
            // alert('checked');
          } else {
            document.getElementById("moderntrade").checked = false;
            document.getElementById("mo_1").checked = false;
            document.getElementById("mo_2").checked = false;
            document.getElementById("mo_3").checked = false;
            document.getElementById("mo_4").checked = false;
            document.getElementById("mo_po1").checked = false;
            document.getElementById("mo_po2").checked = false;
            document.getElementById("mo_po3").checked = false;
            document.getElementById("mo_po4").checked = false;
            document.getElementById("mo_po5").checked = false;
            document.getElementById("mo_po6").checked = false;
            document.getElementById("mo_po7").checked = false;
            document.getElementById("mo_po8").checked = false;
            document.getElementById("mo_po9").checked = false;
            document.getElementById("mo_po10").checked = false;
            document.getElementById("mo_po11").checked = false;
            document.getElementById("mo_po12").checked = false;
            document.getElementById("mo_po13").checked = false;
            document.getElementById("mo_po14").checked = false;
            document.getElementById("mo_po15").checked = false;
            document.getElementById("mo_po16").checked = false;
          }
        })

        const checkbox_2 = document.getElementById('moderntrade')

        checkbox_2.addEventListener('change', (event) => {
          if (event.target.checked) {
            $('#mo_all').show();
            $('#group_1').show();
            $('#group_2').show();
            $('#group_3').show();
            $('#group_4').show();
            $('#end_group_1').show();

            document.getElementById("modern_all").checked = true;
            document.getElementById("mo_1").checked = true;
            document.getElementById("mo_2").checked = true;
            document.getElementById("mo_3").checked = true;
            document.getElementById("mo_4").checked = true;
            document.getElementById("mo_po1").checked = true;
            document.getElementById("mo_po2").checked = true;
            document.getElementById("mo_po3").checked = true;
            document.getElementById("mo_po4").checked = true;
            document.getElementById("mo_po5").checked = true;
            document.getElementById("mo_po6").checked = true;
            document.getElementById("mo_po7").checked = true;
            document.getElementById("mo_po8").checked = true;
            document.getElementById("mo_po9").checked = true;
            document.getElementById("mo_po10").checked = true;
            document.getElementById("mo_po11").checked = true;
            document.getElementById("mo_po12").checked = true;
            document.getElementById("mo_po13").checked = true;
            document.getElementById("mo_po14").checked = true;
            document.getElementById("mo_po15").checked = true;
            document.getElementById("mo_po16").checked = true;
            // alert('checked');
          } else {

            $('#mo_all').hide();
            $('#group_1').hide();
            $('#group_2').hide();
            $('#group_3').hide();
            $('#group_4').hide();
            $('#end_group_1').hide();

            document.getElementById("modern_all").checked = false;
            document.getElementById("mo_1").checked = false;
            document.getElementById("mo_2").checked = false;
            document.getElementById("mo_3").checked = false;
            document.getElementById("mo_4").checked = false;
            document.getElementById("mo_po1").checked = false;
            document.getElementById("mo_po2").checked = false;
            document.getElementById("mo_po3").checked = false;
            document.getElementById("mo_po4").checked = false;
            document.getElementById("mo_po5").checked = false;
            document.getElementById("mo_po6").checked = false;
            document.getElementById("mo_po7").checked = false;
            document.getElementById("mo_po8").checked = false;
            document.getElementById("mo_po9").checked = false;
            document.getElementById("mo_po10").checked = false;
            document.getElementById("mo_po11").checked = false;
            document.getElementById("mo_po12").checked = false;
            document.getElementById("mo_po13").checked = false;
            document.getElementById("mo_po14").checked = false;
            document.getElementById("mo_po15").checked = false;
            document.getElementById("mo_po16").checked = false;
          }
        })

        const checkbox_3 = document.getElementById('mo_1')

        checkbox_3.addEventListener('change', (event) => {
          if (event.target.checked) {
            document.getElementById("mo_1").checked = true;
            document.getElementById("mo_po1").checked = true;
            document.getElementById("mo_po2").checked = true;
            document.getElementById("mo_po3").checked = true;
            document.getElementById("mo_po4").checked = true;
            // alert('checked');
          } else {
            document.getElementById("mo_1").checked = false;
            document.getElementById("mo_po1").checked = false;
            document.getElementById("mo_po2").checked = false;
            document.getElementById("mo_po3").checked = false;
            document.getElementById("mo_po4").checked = false;
          }
        })

        const checkbox_4 = document.getElementById('mo_2')

        checkbox_4.addEventListener('change', (event) => {
          if (event.target.checked) {
            document.getElementById("mo_po5").checked = true;
            document.getElementById("mo_po6").checked = true;
            document.getElementById("mo_po7").checked = true;
            // alert('checked');
          } else {
            document.getElementById("mo_po5").checked = false;
            document.getElementById("mo_po6").checked = false;
            document.getElementById("mo_po7").checked = false;
          }
        })

        const checkbox_5 = document.getElementById('mo_3')

        checkbox_5.addEventListener('change', (event) => {
          if (event.target.checked) {
            document.getElementById("mo_po8").checked = true;
            document.getElementById("mo_po9").checked = true;
            document.getElementById("mo_po10").checked = true;
            document.getElementById("mo_po11").checked = true;
            document.getElementById("mo_po12").checked = true;
            // alert('checked');
          } else {
            document.getElementById("mo_po8").checked = false;
            document.getElementById("mo_po9").checked = false;
            document.getElementById("mo_po10").checked = false;
            document.getElementById("mo_po11").checked = false;
            document.getElementById("mo_po12").checked = false;
          }
        })

        const checkbox_6 = document.getElementById('mo_4')

        checkbox_6.addEventListener('change', (event) => {
          if (event.target.checked) {
            document.getElementById("mo_po13").checked = true;
            document.getElementById("mo_po14").checked = true;
            document.getElementById("mo_po15").checked = true;
            document.getElementById("mo_po16").checked = true;
          } else {
            document.getElementById("mo_po13").checked = false;
            document.getElementById("mo_po14").checked = false;
            document.getElementById("mo_po15").checked = false;
            document.getElementById("mo_po16").checked = false;
          }
        })


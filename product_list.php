<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body onload="load_doc()">
    <div>
        <div id="out"></div>
        <br>
        <div id="out2"></div>
    </div>
    <script>
        let arr;
        lable = ['item_id', 'product code', 'product_name', 'brand', 'หน่วยนับ', 'ราคาขาย', 'Stock_Quantity'];

        function load_doc() {
            let xhttp = new XMLHttpRequest();
            out = document.getElementById("out");
            xhttp.onreadystatechange = function() {
                console.log(this.readyState + ", ", this.status);
                if (this.readyState == 4 && this.status == 200) {
                    arr = JSON.parse(this.responseText);

                    text = "<table border='1'>";
                    for (i = 0; i < lable.length - 1; i++) {
                        text += "<th>" + lable[i] + "</th>";
                    }
                    text = "<tr>" + text + "</tr>";
                    for (i = 0; i < arr.length; i++) {
                        for (j = 0; j < arr[i].length - 1; j++) {
                            text += "<td>" + arr[i][j] + "</td>";
                        }
                        text += "<td>" + "<button onclick='sel_product(" + i + ")'> < ShopShock > </button>" + "</td>";
                        text = "<tr>" + text + "</tr>";
                    }
                    text += "</table>";
                }
                out.innerHTML = text;
            }
            xhttp.open("GET", "product_rest.php", true);
            xhttp.send();
        }

        function sel_product(idx) {
            out = document.getElementById("out2");
            text = "<form>";
            text += "<table border='1'>";
            for (i = 0; i < lable.length - 1; i++) {
                text += "<tr><td>" + lable[i] + "</td>";
                text += "<td>" + arr[idx][i] + "</td></tr>";
            }
            text += "<tr><td>" + lable[6] + "</td>";
            text += "<td><input type='number' name='' id='n"+idx+"' min='1' max='" + arr[idx][6] + "'></td></tr>";
            text += "<tr><td colspan='2'><button onclick='open_op("+idx+")'>Add to Cart</button><input type='reset' value='Reset'></td></tr>";
            text += "</table></form>";
            out.innerHTML = text;
        }

        function open_op(idx){
            qty = document.getElementById("n"+idx);
            alert(arr[idx][1]+"="+qty.value);
            let xhttp = XMLHttpRequest();
            xhttp.onreadystatechange = function() {

            };
            xhttp.open("POST","product_rest.php",true);
            xhttp.setRequestHeader();
            xhttp.send();

        }
    </script>
</body>

</html>
<!DOCTYPE html>
<html>
    <head>
        <script>
        function subst() {
            var vars={};
            var x=window.location.search.substring(1).split('&');
            for (var i in x) {var z=x[i].split('=',2);vars[z[0]] = unescape(z[1]);}
            var x=['frompage','topage','page','webpage','section','subsection','subsubsection'];
            for (var i in x) {
                var y = document.getElementsByClassName(x[i]);
                for (var j=0; j<y.length; ++j) y[j].textContent = vars[x[i]];
            }
        }
        </script>
    </head>
    <body onload="subst()">
        <table width="100%">
            <tr>
                <td style="text-align:left">
                    Página <span class="page"></span> de <span class="topage"></span>
                </td>
                <td style="text-align:right">
                    <!--Generacion: <?php echo date('d/m/Y');?>-->
                </td>
            </tr>
        </table>
    </body>
</html>

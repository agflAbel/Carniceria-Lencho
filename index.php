<?php 
include('views/header.php'); 
include(__DIR__.'/sistema.class.php');
$app=new Sistema;
$sql= "SELECT m.marca, sum(vd.cantidad*p.precio) as monto from 
  marca m join producto p on m.id_marca=p.id_marca
  join venta_detalle vd on vd.id_producto=p.id_producto
  group by m.marca order by m.marca asc;";
$datos=$app->query($sql);
$app->checkRol('Administrador',true);
?>
    <script type="text/javascript">
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["Element", "Density", { role: "style" } ],
        <?php foreach($datos as $dato):?>
          ["<?php echo $dato['marca']; ?>",<?php echo $dato['monto']; ?> , "#b87333"],
        <?php endforeach;?>
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Monto generado por mis marcas",
        width: 600,
        height: 400,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.BarChart(document.getElementById("barchart_values"));
      chart.draw(view, options);
  }
  </script>
  <div id="barchart_values" style="width: 900px; height: 300px;"></div>
<?php include __DIR__.'/views/footer.php'; ?>

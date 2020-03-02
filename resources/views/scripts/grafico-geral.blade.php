<script type="text/javascript">
  google.charts.load("current", {packages:['corechart']});
  google.charts.setOnLoadCallback(chartGeral);

  function chartGeral() {
    var data = google.visualization.arrayToDataTable([
      ["DESCRIÇÃO", "QUANTIDADE", { role: "style" } ],
      ["TOTAL", {{$faltasGerais["total"]}}, "#0000FF"],
      ["PAGAS", {{$faltasGerais["pagas"]}}, "#228B22"],
      ["NÃO PAGAS", {{$faltasGerais["nopagas"]}}, "#B22222"]
    ]);

    var view = new google.visualization.DataView(data);
    view.setColumns([0, 1,
                     { calc: "stringify",
                       sourceColumn: 1,
                       type: "string",
                       role: "annotation" },
                     2]);

    var options = {
      title: 'FALTAS GERAIS DO CURSO: TOTAL, PAGAS e NÃO PAGAS | {{$strSemestre}}',
      bar: {groupWidth: "95%"},
      legend: { position: "none" },
    };
    var chart = new google.visualization.ColumnChart(document.getElementById("faltas_gerais"));
    chart.draw(view, options);
  }

  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(chartIndividual);

  function chartIndividual() {
    var data = google.visualization.arrayToDataTable([
       ['PROFESSOR', 'TOTAL', { role: 'annotation'}, 'PAGAS', { role: 'annotation'}, 'NÃO PAGAS', { role: 'annotation'}],
        @foreach ($faltasIndividuais as $professor => $faltas)
          ['{{$professor}}', {{$faltasIndividuais[$professor]["total"]}}, '{{$faltasIndividuais[$professor]["total"]}}',       {{$faltasIndividuais[$professor]["pagas"]}}, '{{$faltasIndividuais[$professor]["pagas"]}}',        {{$faltasIndividuais[$professor]["nopagas"]}}, '{{$faltasIndividuais[$professor]["nopagas"]}}'],
        @endforeach
    ]);

    var options = {
      title: 'FALTAS INDIVIDUAIS DO CURSO: TOTAL, PAGAS e NÃO PAGAS | {{$strSemestre}}',
      colors: ['#0000FF', '#228B22', '#B22222']
    };  

    // Instantiate and draw the chart.
    var chart = new google.visualization.ColumnChart(document.getElementById('12'));
    chart.draw(data, options);
  }

  // GRÁFICO DE CADA PROFESSOR COM FALTA
  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(chartProfessor);

  function chartProfessor() {
    @foreach ($faltasIndividuais as $professor => $faltas)
      var data = google.visualization.arrayToDataTable([
        ['DESCRIÇÃO', 'QUANTIDADE', { role: "style" }],
        ["TOTAL", {{$faltasIndividuais[$professor]["total"]}}, "#0000FF"],
        ["PAGAS", {{$faltasIndividuais[$professor]["pagas"]}}, "#228B22"],
        ["NÃO PAGAS", {{$faltasIndividuais[$professor]["nopagas"]}}, "#B22222"]
      ]);

    var view = new google.visualization.DataView(data);
    view.setColumns([0, 1,
                     { calc: "stringify",
                       sourceColumn: 1,
                       type: "string",
                       role: "annotation" },
                     2]);

      var options = {
        title: 'FALTAS INDIVIDUAIS | PROFESSOR: {{$professor}} | SEMESTRE: {{$strSemestre}}',
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };  

      // Instantiate and draw the chart.
      var chart = new google.visualization.ColumnChart(document.getElementById('{{$professor}}'));
      chart.draw(view, options);
    @endforeach
  }
</script>
<script>
  function updateClock() {
    var now = new Date();
    var hours = now.getHours();
    var minutes = now.getMinutes();
    var seconds = now.getSeconds();
    var ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    minutes = minutes < 10 ? '0' + minutes : minutes;
    seconds = seconds < 10 ? '0' + seconds : seconds;
    var strTime = hours + ':' + minutes + ':' + seconds + ' ' + ampm;
    document.getElementById('digital-clock').innerHTML = strTime;
  }

  setInterval(updateClock, 1000);
  updateClock();
</script>

<script>
  let table = new DataTable('#myTable');
</script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('barChart').getContext('2d');
    var data = <?php echo json_encode($data); ?>;
    var years = data.map(item => item.year);
    var jobsGenerated = data.map(item => item.jobsGenerated);
    var personsEmployed = data.map(item => item.personsEmployed);

    var barChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: years,
        datasets: [
          {
            label: 'Jobs Generated',
            data: jobsGenerated,
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
          },
          {
            label: 'Persons Employed',
            data: personsEmployed,
            backgroundColor: 'rgba(153, 102, 255, 0.2)',
            borderColor: 'rgba(153, 102, 255, 1)',
            borderWidth: 1
          }
        ]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  });
</script>

<script>
  var ctx = document.getElementById('lineChart').getContext('2d');
  var lineChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: <?php echo json_encode(array_column($data, 'year')); ?>,
      datasets: [
        {
          label: 'Target Area',
          data: <?php echo json_encode(array_column($data, 'targetArea')); ?>,
          borderColor: 'rgba(75, 192, 192, 1)',
          backgroundColor: 'rgba(75, 192, 192, 0.2)',
          fill: false
        },
        {
          label: 'Area Planted',
          data: <?php echo json_encode(array_column($data, 'areaPlanted')); ?>,
          borderColor: 'rgba(153, 102, 255, 1)',
          backgroundColor: 'rgba(153, 102, 255, 0.2)',
          fill: false
        }
      ]
    },
    options: {
      responsive: true,
      scales: {
        x: {
          title: {
            display: true,
            text: 'Year'
          }
        },
        y: {
          title: {
            display: true,
            text: 'Area'
          }
        }
      }
    }
  });
</script>
/* Dashboard Chart Renderer */

(function () {
  function parseJsonFromScript(id, fallback) {
    const el = document.getElementById(id);
    if (!el) return fallback;
    try {
      return JSON.parse(el.textContent || el.innerHTML || '');
    } catch (e) {
      return fallback;
    }
  }

  // Avoid breaking if Chart.js is not loaded
  if (typeof window.Chart !== 'function') return;

  const analytics = parseJsonFromScript('dashboard-analytics', {});
  const kategoriLabels = parseJsonFromScript('dashboard-kategori-labels', []);
  const kategoriCounts = parseJsonFromScript('dashboard-kategori-counts', []);

  const stockTrendData = analytics.stockTrendData || [];
  const topIncoming = analytics.topIncoming || [];
  const topOutgoing = analytics.topOutgoing || [];
  const conditionStats = analytics.conditionStats || {};
  const colors = [
    'rgba(54, 162, 235, 0.7)',
    'rgba(255, 193, 7, 0.7)',
    'rgba(75, 192, 192, 0.7)',
    'rgba(153, 102, 255, 0.7)',
    'rgba(255, 159, 64, 0.7)',
  ];

  const elStock = document.getElementById('stockTrendChart');
  if (elStock) {
    new Chart(elStock, {
      type: 'bar',
      data: {
        labels: stockTrendData.map((item) => item.kategori),
        datasets: [
          {
            label: 'Rata-rata Stok',
            data: stockTrendData.map((item) => item.avg_stok),
            backgroundColor: colors,
            borderWidth: 1,
          },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true } },
      },
    });
  }

  const elKategori = document.getElementById('kategoriChart');
  if (elKategori) {
    new Chart(elKategori, {
      type: 'pie',
      data: {
        labels: kategoriLabels,
        datasets: [
          {
            data: kategoriCounts,
            backgroundColor: colors,
          },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { position: 'bottom' } },
      },
    });
  }

  const elIncoming = document.getElementById('topIncomingChart');
  if (elIncoming) {
    new Chart(elIncoming, {
      type: 'bar',
      data: {
        labels: topIncoming.map((item) => item.nama),
        datasets: [
          {
            label: 'Jumlah Masuk',
            data: topIncoming.map((item) => item.total),
            backgroundColor: 'rgba(76, 175, 80, 0.7)',
            borderWidth: 1,
          },
        ],
      },
      options: {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: { x: { beginAtZero: true } },
      },
    });
  }

  const elOutgoing = document.getElementById('topOutgoingChart');
  if (elOutgoing) {
    new Chart(elOutgoing, {
      type: 'bar',
      data: {
        labels: topOutgoing.map((item) => item.nama),
        datasets: [
          {
            label: 'Jumlah Keluar',
            data: topOutgoing.map((item) => item.total),
            backgroundColor: 'rgba(244, 67, 54, 0.7)',
            borderWidth: 1,
          },
        ],
      },
      options: {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: { x: { beginAtZero: true } },
      },
    });
  }

  const elCondition = document.getElementById('conditionChart');
  if (elCondition) {
    new Chart(elCondition, {
      type: 'doughnut',
      data: {
        labels: Object.keys(conditionStats),
        datasets: [
          {
            data: Object.values(conditionStats),
            backgroundColor: [
              'rgba(76, 175, 80, 0.7)',
              'rgba(255, 193, 7, 0.7)',
              'rgba(244, 67, 54, 0.7)',
            ],
          },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { position: 'bottom' } },
      },
    });
  }
})();


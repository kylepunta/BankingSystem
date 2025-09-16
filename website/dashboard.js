  (async () => {
  const res = await fetch('./summary.php');
  const s = await res.json();

  // Example stat card element IDs – change to your actual IDs
  document.querySelector('.customers.count').textContent = s.Customer.toLocaleString();
  document.querySelector('.deposit-accounts.count').textContent = s.DepositAccount.toLocaleString();
  document.querySelector('.current-accounts.count').textContent  = s.CurrentAccount.toLocaleString();
  document.querySelector('.loan-accounts.count').textContent = s.LoanAccount.toLocaleString();
})();
  
  // // Example labels: last 12 months
  // const labels = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

  // // Line chart: Deposits vs Withdrawals
  // new Chart(document.getElementById("chart-flows"), {
  //   type: "line",
  //   data: {
  //     labels,
  //     datasets: [
  //       { label: "Deposits", data: [120,140,110,180,160,200,220,210,230,240,260,300] },
  //       { label: "Withdrawals", data: [80,95,100,120,130,150,160,170,165,180,190,210] }
  //     ]
  //   },
  //   options: {
  //     responsive: true,
  //     maintainAspectRatio: false,
  //     tension: 0.35,
  //     plugins: { legend: { position: "bottom" } },
  //     scales: { y: { beginAtZero: true } }
  //   }
  // });

(async () => {
  try {
    const res = await fetch('./flows.php'); // adjust path if needed
    if (!res.ok) throw new Error(`HTTP ${res.status}`);
    const { labels, deposits, withdrawals } = await res.json();

    new Chart(document.getElementById('chart-flows'), {
      type: 'line',
      data: {
        labels,
        datasets: [
          { label: 'Deposits',    data: deposits,    borderColor: '#36a2eb', fill: false, tension: 0.35 },
          { label: 'Withdrawals', data: withdrawals, borderColor: '#ff6384',   fill: false, tension: 0.35 }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { position: 'bottom' } },
        scales: { y: { beginAtZero: true } }
      }
    });
  } catch (err) {
    console.error('flows.php failed:', err);
  }
})();


  // // Donut: Account distribution
  // new Chart(document.getElementById("chart-accounts"), {
  //   type: "doughnut",
  //   data: {
  //     labels: ["Deposit", "Loan", "Current"],
  //     datasets: [{ data: [842, 312, 529], backgroundColor: [
  //       "#10b981", 
  //       "#f59e0b", 
  //       "#3b82f6",
  //     ]}],
      
  //   },
  //   options: {
  //     responsive: true,
  //     maintainAspectRatio: false,
  //     plugins: { legend: { position: "bottom" } },
  //     cutout: "75%"
  //   }
  // });

  (async () => {
  const res = await fetch('./summary.php'); // same endpoint you already use for stat cards
  if (!res.ok) throw new Error(`HTTP ${res.status}`);
  const s = await res.json();

  // Expecting keys returned by summary.php:
  // s.DepositAccount, s.LoanAccount, s.CurrentAccount

  new Chart(document.getElementById("chart-accounts"), {
    type: "doughnut",
    data: {
      labels: ["Deposit", "Loan", "Current"],
      datasets: [{
        data: [
          Number(s.DepositAccount) || 0,
          Number(s.LoanAccount)    || 0,
          Number(s.CurrentAccount) || 0
        ],
        backgroundColor: ["#10b981","#f59e0b","#3b82f6"]
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { position: "bottom" } },
      cutout: "75%"
    }
  });
})();

(async () => {
  try {
    const res = await fetch('transactions.php'); // adjust path if in /api
    if (!res.ok) throw new Error(`HTTP ${res.status}`);
    const rows = await res.json();

    const tbody = document.querySelector('.transactions-table tbody');
    if (!tbody) return;
    tbody.innerHTML = '';

    for (const r of rows) {
      const tr = document.createElement('tr');

      // Try to format the date nicely if it parses; else show raw
      const d = new Date(r.tx_date);
      const dateText = isNaN(d)
      ? r.tx_date
      : d.toLocaleDateString(undefined, { year: 'numeric', month: 'short', day: '2-digit' });
      // e.g. "16 Sep 2025"


      tr.innerHTML = `
        <td>${dateText}</td>
        <td>${r.customer}</td>
        <td>${r.account_no}</td>
        <td>${r.type}</td>
        <td>${Number(r.amount).toLocaleString(undefined, { style: 'currency', currency: 'EUR' })}</td>
      `;
      tbody.appendChild(tr);
    }
  } catch (err) {
    console.error('transactions.php failed:', err);
  }
})();

const addCustomerBtn = document.querySelector(".action-button.add");
const lodgeBtn = document.querySelector(".action-button.lodge");
const withdrawBtn = document.querySelector(".action-button.withdraw");

addCustomerBtn.addEventListener("click", () => {
  window.location.href = "./kyle/add-customer.html.php";
})

lodgeBtn.addEventListener("click", () => {
  window.location.href = "./kyle/lodgements.html.php";
})

withdrawBtn.addEventListener("click", () => {
  window.location.href = "./darian/withdrawals/index.php";
})




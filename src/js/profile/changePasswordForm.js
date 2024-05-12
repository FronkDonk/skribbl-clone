document
  .getElementById("password-form")
  .addEventListener("submit", async (event) => {
    event.preventDefault();
    const password = document.getElementById("password").value;
    const newPassword = document.getElementById("newPassword").value;
    const confirmPassword = document.getElementById("confirmPassword").value;

    if (newPassword !== confirmPassword) {
      alert("Passwords do not match");
      return;
    }

    const res = await fetch("/api/changePassword", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: `password=${password}&newPassword=${newPassword}`,
    });

    if (!res.ok) {
      const data = await res.json();
      alert(data.message);
    } else {
      alert("Password changed successfully");
    }
  });

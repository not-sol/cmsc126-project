<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7"
    crossorigin="anonymous"
  />
  <title>Multi-Form Validation</title>
</head>
<body>

  <!-- First Form -->
  <form novalidate method="post">
    <div class="form-floating my-3">
      <input type="email" class="form-control" placeholder="Email" name="email" required>
      <label class="form-label">Email</label>
      <div class="invalid-feedback">Please fill out this field.</div>
    </div>
    <div class="form-floating my-3">
      <input type="password" class="form-control" placeholder="Password" name="password" required>
      <label class="form-label">Password</label>
      <div class="invalid-feedback">Please fill out this field.</div>
    </div>
    <button type="submit" class="btn btn-dark">Submit</button>
  </form>

  <!-- Second Form -->
  <form novalidate method="post">
    <div class="form-floating my-3">
      <input type="email" class="form-control" placeholder="Email" name="email" required>
      <label class="form-label">Email</label>
      <div class="invalid-feedback">Please fill out this field.</div>
    </div>
    <div class="form-floating my-3">
      <input type="password" class="form-control" placeholder="Password" name="password" required>
      <label class="form-label">Password</label>
      <div class="invalid-feedback">Please fill out this field.</div>
    </div>
    <button type="submit" class="btn btn-dark">Submit</button>
  </form>

  <script>
    // Apply validation to all forms
    const forms = document.querySelectorAll("form");

    forms.forEach(form => {
      form.addEventListener("submit", function (e) {
        if (!form.checkValidity()) {
          e.preventDefault(); // Stop form submission
        }
        form.classList.add("was-validated"); // Trigger Bootstrap's visual feedback
      });
    });
  </script>
</body>
</html>

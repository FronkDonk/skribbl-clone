import * as z from "zod";

const signInSchema = z.object({
  email: z.string().email(),
  password: z.string().min(8),
});

document
  .getElementById("signInForm")
  .addEventListener("submit", async function (event) {
    event.preventDefault(); // Prevent the form from being submitted normally

    const formData = new FormData(this); // Create a FormData object from the form

    const data = {
      email: formData.get("email"),
      password: formData.get("password"),
    };

    const result = signInSchema.safeParse(data);

    if (!result.success) {
      alert("Invalid data");
      //return error message or something

      console.error(result.error);
    }
    // Send the form data to the server with fetch
    const res = await fetch("/api/auth/sign-in", {
      method: "POST",
      body: formData,
    });
    if (!res.ok) {
      const data = await res.json();
      console.log(`Error: ${data.message}`);
      alert("Error signing in. Please try again.");
    } else {
      const { data } = await res.json();
      // Log the response body to the console
      console.log(data);
      window.location.href = "/create-game";
    }
  });

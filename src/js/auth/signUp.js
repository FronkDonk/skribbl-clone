import * as z from "zod";

const signUpSchema = z.object({
  username: z.string().min(3),
  email: z.string().email(),
  password: z.string().min(8),
});

document
  .getElementById("signUpForm")
  .addEventListener("submit", async function (event) {
    event.preventDefault(); // Prevent the form from being submitted normally

    const formData = new FormData(this); // Create a FormData object from the form

    const data = {
      username: formData.get("username"),
      email: formData.get("email"),
      password: formData.get("password"),
    };

    const result = signUpSchema.safeParse(data);

    if (!result.success) {
      //return error message or something
      alert("Invalid data");

      console.error(result.error);
    }
    // Send the form data to the server with fetch
    const res = await fetch("/api/auth/sign-up", {
      method: "POST",
      body: formData,
    });
    if (!res.ok) {
      alert("Error signing up. Please try again.");
    } else {
      const { data } = await res.json();
      // Log the response body to the console
      window.location.href = "/create-game";
    }
  });

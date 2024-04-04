import { z } from "zod";

export const userSchema = z.object({
  owner: z.boolean(),
  username: z.string(),
  isClient: z.boolean(),
});

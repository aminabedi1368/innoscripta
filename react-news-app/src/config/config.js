export const navbarBrand = "Innoscripta News App";
export const header = (category) => `News - Top ${category} Headlines`;
export const navs = [
  { nav: "Home", page: "/" },
  { nav: "Business", page: "/business" },
  { nav: "Sports", page: "/sports" },
  { nav: "Science", page: "/science" },
  { nav: "Health", page: "/health" },
  { nav: "Login", page: "/login" },
  { nav: "Register", page: "/register" },
  { nav: "Profile", page: "/profile" },
  { nav: "Advanced", page: "/advanced" },
  { nav: "Logout", page: "/logout" },
];

export const router = [
  { path: "/", key: "general", category: "general" },
  { path: "/business", key: "business", category: "business"},
  { path: "/sports", key: "sports", category: "sports" },
  { path: "/science", key: "science", category: "science"},
  { path: "/health", key: "health", category: "health" }
];

export const summary = "Channel and PublishedAt";
export const channel = (channel) => `Channel: ${channel}`;
export const lastUpdate = (published) =>
  `Published at: ${new Date(published).toGMTString()}`;

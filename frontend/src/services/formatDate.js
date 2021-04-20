//FormatDate to display Day Date Month 
export default function formatDate(date) {
  const options = {
    weekday: "long",
    year: "numeric",
    month: "long",
    day: "numeric"
  };
  let formatDate = new Date(date).toLocaleDateString(undefined, options);
  return formatDate.charAt(0).toUpperCase() + formatDate.slice(1);
}

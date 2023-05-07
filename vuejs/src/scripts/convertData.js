export function convertData(data) {
    data.created_at = convertTime(data.created_at)
    data.updated_at = convertTime(data.updated_at)
    data.date = convertTime(data.date)
    return data
  }

function convertTime(data) {
    const date = new Date(Number(data));
    const year = date.getUTCFullYear();
    const month = (date.getUTCMonth() + 1).toString().padStart(2, '0');
    const day = date.getUTCDate().toString().padStart(2, '0');
    const hours = date.getUTCHours().toString().padStart(2, '0');
    const minutes = date.getUTCMinutes().toString().padStart(2, '0');
    const seconds = date.getUTCSeconds().toString().padStart(2, '0');
    return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
}
export async function getSalesmethods() {
    var response = (await axios.get("/index.php/api/sales_methods")).data;
    return response.data;
}
export async function getIndustries() {
    var response = (await axios.get("/index.php/api/industries")).data;
    return response.data;
}
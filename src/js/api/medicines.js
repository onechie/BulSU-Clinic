export const getMedicines = async (id) => {
  const endPoint = "/backend/api/medicines";
  try {
    const params = id ? { id } : {};
    const { data } = await axios.get(endPoint, {
      params,
    });
    return data;
  } catch (error) {
    throw error.response.data;
  }
};
export const addMedicine = async (medicineData) => {
  const endPoint = "/backend/api/medicines";
  try {
    const { data } = await axios.post(endPoint, medicineData);
    return data;
  } catch (error) {
    throw error.response.data;
  }
};
export const updateMedicine = async (medicineData) => {
  const endPoint = "/backend/api/medicines/update";
  try {
    const { data } = await axios.post(endPoint, medicineData);
    return data;
  } catch (error) {
    throw error.response.data;
  }
};

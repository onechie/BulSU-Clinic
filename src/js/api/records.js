export const getRecords = async (id) => {
  const endPoint = "/backend/api/records";
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
export const addRecord = async (recordData) => {
  const endPoint = "/backend/api/records";
  try {
    const { data } = await axios.post(endPoint, recordData);
    return data;
  } catch (error) {
    throw error.response.data;
  }
};

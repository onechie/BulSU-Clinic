export const getMedicines = async (id) => {
  const endPoint = "/backend/api/medicines";
  try {
    const params = id ? { id } : {};
    const { data } = await axios.get(endPoint, {
      params,
    });
    return data;
  } catch (error) {
    return error.response.data;
  }
};

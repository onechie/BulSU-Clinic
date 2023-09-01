export const getLogs = async (id) => {
  const endPoint = "/backend/api/logs";
  try {
    const params = id ? { id } : {};
    const { data } = await axios.get(endPoint, {
      params,
    });
    return data.logs;
  } catch (error) {
    throw error.response.data;
  }
};

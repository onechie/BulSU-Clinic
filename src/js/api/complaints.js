export const getComplaints = async (id) => {
    const endPoint = "/backend/api/complaints";
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
  
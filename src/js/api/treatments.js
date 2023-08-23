export const getTreatments = async (id) => {
    const endPoint = "/backend/api/treatments";
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
  
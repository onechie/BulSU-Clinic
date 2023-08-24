export const getLaboratories = async (id) => {
    const endPoint = "/backend/api/laboratories";
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
  
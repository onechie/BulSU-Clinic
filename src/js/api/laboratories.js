export const getLaboratories = async (id) => {
  const endPoint = "/backend/api/laboratories";
  try {
    const params = id ? { id } : {};
    const { data } = await axios.get(endPoint, {
      params,
    });
    return data.laboratories;
  } catch (error) {
    throw error.response.data;
  }
};

export const addLaboratory = async (laboratory) => {
  const endPoint = "/backend/api/laboratories";
  try {
    const { data } = await axios.post(endPoint, laboratory, {
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
    });
    return data;
  } catch (error) {
    throw error.response.data;
  }
};

export const updateLaboratory = async (laboratory) => {
  const endPoint = "/backend/api/laboratories/update";
  try {
    const { data } = await axios.post(endPoint, laboratory, {
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
    });
    return data;
  } catch (error) {
    throw error.response.data;
  }
};

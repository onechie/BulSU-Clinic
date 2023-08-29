export const getTreatments = async (id) => {
  const endPoint = "/backend/api/treatments";
  try {
    const params = id ? { id } : {};
    const { data } = await axios.get(endPoint, {
      params,
    });
    return data.treatments;
  } catch (error) {
    throw error.response.data;
  }
};

export const addTreatment = async (treatment) => {
  const endPoint = "/backend/api/treatments";
  try {
    const { data } = await axios.post(endPoint, treatment, {
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
    });
    return data;
  } catch (error) {
    throw error.response.data;
  }
};

export const updateTreatment = async (treatment) => {
  const endPoint = "/backend/api/treatments/update";
  try {
    const { data } = await axios.post(endPoint, treatment, {
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
    });
    return data;
  } catch (error) {
    throw error.response.data;
  }
};

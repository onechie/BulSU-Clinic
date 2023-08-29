export const getComplaints = async (id) => {
  const endPoint = "/backend/api/complaints";
  try {
    const params = id ? { id } : {};
    const { data } = await axios.get(endPoint, {
      params,
    });
    return data.complaints;
  } catch (error) {
    throw error.response.data;
  }
};

export const addComplaint = async (complaint) => {
  const endPoint = "/backend/api/complaints";
  try {
    const { data } = await axios.post(endPoint, complaint, {
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
    });
    return data;
  } catch (error) {
    throw error.response.data;
  }
};

export const updateComplaint = async (complaint) => {
  const endPoint = "/backend/api/complaints/update";
  try {
    const { data } = await axios.post(endPoint, complaint, {
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
    });
    return data;
  } catch (error) {
    throw error.response.data;
  }
};

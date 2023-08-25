export const getAttachments = async (id, recordId) => {
  const endPoint = "/backend/api/attachments";
  try {
    const params = id ? { id } : { recordId };
    const { data } = await axios.get(endPoint, {
      params,
    });
    return data;
  } catch (error) {
    throw error.response.data;
  }
};

export const addAttachments = async (data) => {
  const endPoint = "/backend/api/attachments";
  try {
    const response = await axios.post(endPoint, data);
    return response.data;
  } catch (error) {
    throw error.response.data;
  }
};

export const deleteAttachments = async (id, recordId) => {
  const endPoint = "/backend/api/attachments/delete";
  try {
    const params = id ? { id } : { recordId };
    const response = await axios.post(endPoint, params, {
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
    });
    return response.data;
  } catch (error) {
    throw error.response.data;
  }
};

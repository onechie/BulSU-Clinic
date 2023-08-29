export const getStorages = async (id) => {
  const endPoint = "/backend/api/storages";
  try {
    const params = id ? { id } : {};
    const { data } = await axios.get(endPoint, {
      params,
    });
    return data.storages;
  } catch (error) {
    throw error.response.data;
  }
};

export const addStorage = async (storage) => {
  const endPoint = "/backend/api/storages";
  try {
    const { data } = await axios.post(endPoint, storage, {
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
    });
    return data;
  } catch (error) {
    throw error.response.data;
  }
};

export const updateStorage = async (storage) => {
  const endPoint = "/backend/api/storages/update";
  try {
    const { data } = await axios.post(endPoint, storage, {
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
    });
    return data;
  } catch (error) {
    throw error.response.data;
  }
};

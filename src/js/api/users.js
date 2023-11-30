export const loginUser = async (userData) => {
  const endPoint = "/backend/api/users/login";
  try {
    const { data } = await axios.post(endPoint, userData, {
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
    });
    return data;
  } catch (error) {
    throw error.response.data;
  }
};

export const registerUser = async (userData) => {
  const endPoint = "/backend/api/users/register";
  try {
    const { data } = await axios.post(endPoint, userData, {
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
    });
    return data;
  } catch (error) {
    throw error.response.data;
  }
};

export const getUser = async () => {
  const endPoint = "/backend/api/users/me";
  try {
    const { data } = await axios.get(endPoint);
    return data.user;
  } catch (error) {
    throw error.response.data;
  }
};

export const logoutUser = async () => {
  const endPoint = "/backend/api/users/logout";
  try {
    const { data } = await axios.get(endPoint);
    return data;
  } catch (error) {
    throw error.response.data;
  }
};

export const changePassword = async (passwordData) => {
  const endPoint = "/backend/api/users/password/change";
  try {
    const { data } = await axios.post(endPoint, passwordData, {
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
    });
    return data;
  } catch (error) {
    throw error.response.data;
  }
};

export const registerOTP = async (email) => {
  const endPoint = "/backend/api/users/register/otp";
  try {
    const { data } = await axios.post(endPoint, email, {
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
    });
    return data;
  } catch (error) {
    throw error.response.data;
  }
};  
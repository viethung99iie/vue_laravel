
const loginMiddleware = (to, from, next) => {
    const token = localStorage.getItem('token')
	const tokenExpiration = localStorage.getItem('token_expires')
    const tokenExpirationDate = new Date(tokenExpiration)

	if(token && tokenExpirationDate >= new Date()){
		next({
			path: '/dashboard',
		})
		return;
	}

	next();
}

export default loginMiddleware

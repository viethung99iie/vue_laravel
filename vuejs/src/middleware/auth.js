
const authMiddleware = (to, from, next) => {
    const token = localStorage.getItem('token')
	const tokenExpiration = localStorage.getItem('token_expires')
	if(!token || !tokenExpiration){
		next({
			path: '/admin',
		})
		return;
	}

	const tokenExpirationDate = new Date(tokenExpiration)

	if(tokenExpirationDate < new Date()){
		next({
			path: '/admin',
		})
		return;
	}
	next();
}

export default authMiddleware

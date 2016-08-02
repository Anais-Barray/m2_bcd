diff <- read.csv(file="output_0.3.txt",header=F)[[1]]

hist(diff,freq=F)
mu <- mean(diff)
sigma <- sd(diff)
x <- seq(-1,1,by=0.001)
lines(x=x,y=dnorm(x,mean=mu,sd=sigma),type="l",col="red")
q <- qnorm(0.025,mean=mu,sd=sigma)
abline(v=q,col="red")
q <- qnorm(1-0.025,mean=mu,sd=sigma)
abline(v=q,col="red")

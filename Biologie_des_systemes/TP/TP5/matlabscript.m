a=linspace(0,6,200);
alpha=0.1; k=1; K=3; e_0=1; n=50;
plot(a,((k*e_0)./(1+(a/K).^n)))
hold on;
plot(a,alpha*a)
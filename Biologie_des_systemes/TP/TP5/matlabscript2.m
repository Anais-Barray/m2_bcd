a=linspace(0,6,200);
alpha=0.1; k=1; K=3; a_0=1; n=50;
plot(a,((k*(a/a_0).^n)./(1+(a/a_0).^n)));
hold on
plot(a,alpha*a);

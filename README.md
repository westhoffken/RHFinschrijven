# RHFinschrijven
In dit project het inschrijf formulier voor Royal Health Foam gemaakt door Kenneth en Nathan

#Visie
Het abboneren op de koopjeshoek mogelijk maken. Dit zou het bijvoorbeeld makkelijker maken om een koopjeshoek matras te kopen, en natuurlijk zal het voor RHF zelf minder tijde kosten
omdat klanten zichzelf kunnen bedienen.

#Project structuur
Dit project is gebouwd op basis van het Symfony (PHP) framework.
Achter dit framework wordt gewerkt met een MySql database en PHP 7.4.
Symfony werkt met zogeheten Entities en kan middels de database manager (Doctrine) de gehele structuur in de database neerzetten.
Tevens wordt er gewerkt met composer (php package manager) om de packages te managen en te installeren.

#Werking project
LET OP! Het is altijd onze visie geweest om dit inschrijf formulier te koppelen aan het product systeem van RHF.
Omdat wij geen toegang hebben tot dit systeem hebben we dit anders opgelost!

Zodra iemand zich inschrijft voor een matras kan er middels het "Scrape command" gekeken worden op de website van RHF of dit matras beschikbaar is.
Dit command (lees cron) kan ingesteld worden om te draaien wanneer dit gewenst is. Nogmaals gezegd, als dit geïntegreerd wordt in het eigen product management systeem zal dit NIET
nodig zijn en kan, als er een nieuw product op de website gezet wordt, dit aan de betreffende persoon bekend gemaakt worden.




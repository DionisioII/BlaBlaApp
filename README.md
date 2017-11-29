# BlaBlaApp

## Synopsis

This is a web project written with zend framework version 1.12.18

Project of a social community: a user can register himself on the community, create blogs, post on them,

see other profiles and blogs, comment on other people's posts and stuff....


## Installation

In order to use it you have to set up a mysql database and change the bootstrap file setting your hostname , database name, username and password.

The mysql dump file is located in the public folder.     

## API Reference

Zend framework version 1.12.18



## Full Specs (italian):

Un’azienda vuole realizzare un portale per la gestione di una comunità di utenti organizzati secondo un modello
di social network. Attraverso un’applicazione WEB un navigatore può:

   • visualizzare le informazioni generali sulla comunità e sulla società che gestisce il sito;
   • iscriversi alla comunità stessa inserendo i suoi dati anagrafici ed un breve profilo che lo descrive.
   
Una volta iscritto, può:

   • decidere se rendersi visibile a tutti gli altri o solo al sotto-insieme della comunità costituito dagli utenti
   suoi “amici”;
   
   • verificare se un altro individuo è iscritto o meno alla comunità, accedendo ad una funzione di ricerca
   tramite l’indicazione del nome e/o cognome della persona cercata. Se questa è presente e visibile a
   tutti, la funzione restituisce tutti i dati del membro della comunità (dati anagrafici e profilo). Se invece
   la persona cercata ha scelto di essere visibile solo ai suoi amici, la ricerca restituisce i dati completi se
   attivata da un amico, il solo nome e cognome negli altri casi;
   
   • chiedere di entrare nel gruppo degli amici di un altro, inviando una richiesta in tal senso. La richiesta
   può essere accettata o meno dal destinatario, e resta memorizzata in modo permanente nel sistema,
   assieme all’indicazione della data in cui è stata emessa. Se un utente A accetta la richiesta di amicizia
   fatta da un utente B, B diviene amico di A ed A di B. Ogni utente può appartenere a più gruppi;
   
   • eliminare dal gruppo dei suoi amici chiunque quando vuole; in questo caso l’utente eliminato riceve un
   messaggio di notifica.
   
   • attivare un suo blog (pagina di testo in cui esprimere opinioni su un tema a sua scelta) al quale
   possono accedere anche i suoi amici sia in lettura che in scrittura, per inserire commenti alle opinioni
   del blogger.

ogni nuovo post sul blog è identificato dalla data, dall’ora di inserimento e dal mittente, e si
aggiunge in coda ai precedenti;

ogni volta che un post viene aggiunto ad un blog, tutti coloro che vi hanno accesso ricevono
una notifica (data, ora e mittente del post).

In sintesi, gli utenti dell’applicazione possono:

   • accedere alle informazioni generali che descrivono:


               •l’azienda che gestisce il portale;

               •le funzionalità del portale;

               •le condizioni d’uso (regole di comportamento dei membri della comunità);
               • iscriversi alla comunità specificando i dati personali;
               • gestire le proprie amicizie (accettare/rifiutare richieste di amicizia, eliminare gli amici);
               • ricercare una persona all’interno della comunità;
               • inviare ad un membro la richiesta di far parte del proprio gruppo di amici;
               • creare un blog ed inserire post in esso;
               • visualizzare i blog degli amici ed inserire post;
               • commentare post degli amici
               
               
Operativamente, nella realizzazione del sito, si tenga conto delle seguenti specifiche funzionali:

• Gestione gruppo di amici. Ogni membro può:

   •  ricercare un altro membro della comunità per chiedere di entrare nel suo gruppo di amici. Per
      la ricerca può specificare i valori di nome e/o cognome (anche parzialmente tramite il
      carattere wild-card “*”, ammesso solo come ultimo carattere del pattern di ricerca: ad
      esempio “Lu*” come indicazione del nome per ricercare “Luca”, “Luigi”, “Lucrezia”, ...). Dalla
      lista dei risultati sia possibile selezionare un elemento per visualizzare il profilo del membro
      corrispondente.
   • richiedere di diventare amico di qualcuno;
   • visualizzare ed accettare/rifiutare le singole richieste di amicizia a lui pervenute;
   • visualizzare l’elenco dei suoi amici ed il profilo di ciascuno;
   • cancellare qualcuno dal proprio gruppo di amici.
   
• Gestione blog. Ogni membro può:

      •creare uno o più blog, specificandone il tema e postando il primo
      messaggio;
      
      • postare messaggi sul suo blog o su quelli degli amici;

      • cancellare il suo blog (integralmente).
      
      
Relativamente alle modalità di accesso al sito, è definita definisca una policy diversificata articolata nei seguenti livelli:

Livello 0: area pubblica del sito, cioè disponibile con le sue informazioni a tutti coloro che accedono al
sito (inclusi gli utenti generici non registrati), contenente:

   • la presentazione dell’azienda, compresi i riferimenti per i contatti (telefono, e-mail, ...);
   • le informazioni generali sulla comunità (scopo, regole di partecipazione, ...)
   • le caratteristiche, le funzionalità e le condizioni d’uso del portale;
   •la FORM di iscrizione alla comunità.
   
   
Livello 1: aree riservate ai membri della comunità che possono:

      • modificare il proprio profilo personale;
      • gestire il gruppo di amici;
      • gestire i prori blog;
      • postare sul blog degli amici;
      • commentare i post degli amici
      • editare un blacklist realativa ad ogni blog per escludere utenti indesiderati
      
Livello 2: aree riservate allo staff che gestisce il sito, i cui membri possono:

   • visualizzare il contenuto dei blog di tutti gli utenti;
   • cancellare interi blog o singoli post ritenuti non in linea con il comportamento stabilito per i membri
      della comunità. Ad ogni cancellazione corrisponde l’invio di un messaggio a chi ha inserito l’oggetto
      cancellato con l’indicazione del motivo dell’azione;
      
      
      
Livello 3: aree riservate l’amministratore del sito, che, oltre alle funzionalità del livello precedente:
 • gestisce (inserisce/cancella/modifica):

            i membri dello staff;
            
            
• estrae informazioni sulla comunità quali:
      
      •la composizione (nome e cognome dei membri) del gruppo di amici di un dato membro
      della comunità;
      
      •il numero di richieste di amicizia ricevute (accettate o meno) da un dato membro
      della comunità;
      
     • il numero totale di blog creati dai membri della comunità;
      Sono lasciate al progettista dell’applicazione le scelte relative ai dati descrittivi dei singoli “oggetti” da
      rappresentare (utenti, blog, foto, ecc.), nel rispetto delle specifiche definite.
      
Livello 3: aree riservate l’amministratore del sito, che, oltre alle funzionalità del livello precedente:

      • gestisce (inserisce/cancella/modifica):

            •i membri della comunità ed i relativi profili (in questo caso si escluda la funzione di
            inserimento);

      •i membri dello staff;
            •estrae informazioni sulla comunità quali:

      •la composizione (nome e cognome dei membri) del gruppo di amici di un dato membro
      della comunità;

      •il numero di richieste di amicizia ricevute (accettate o meno) da un dato membro
      della comunità;

      •il numero totale di blog creati dai membri della comunità;



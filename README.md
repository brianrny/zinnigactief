# Zinnigactief

#### - Vichuploader geimplementeerd
#### - CKEditor is toegepast bij de activity.description en vertaalt html tags om naar tekst 
#### - Homepagina toont nu activities inplaats van users
#### - Events die worden aangemaakt kan nu een afbeelding bevatten en die wordt opgeslagen in public/images/activity, afbeelding is niet vereist, als er geen afbeelding wordt meegegeven dan wordt er een default image displayed. 
#### - Elke activity in de slider is clickable en stuurd je naar de /activity/{id}
#### - Meeste witte achtergrond kleuren zijn veranderd naar blauwe mborijnland kleur i.v.m de tekst kleur dat de ckeditor toont (valt niet te veranderen, confirmed by Robben).
#### - Gebruikte svg's zijn nu wit

Run :


  php bin/console asset:install
 
  php bin/console ckeditor:install
  
  

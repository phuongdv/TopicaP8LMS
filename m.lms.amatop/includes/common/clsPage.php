 < ? p h p 
 i f ( i s s e t ( $ _ S E S S I O N [ " N V C O M _ r o o t _ N V C _ r o o t _ L A N G " ] )   & &   $ _ S E S S I O N [ " N V C O M _ r o o t _ N V C _ r o o t _ L A N G " ] = = " e n " ) 
 	 { 
 	 	 d e f i n e ( " _ P a g e " , " P a g e " ) ; 
 	 	 d e f i n e ( " _ P r e v " , " P r e v i o u s " ) ; 
 	 	 d e f i n e ( " _ N e x t " , " N e x t " ) ; 
 	 } 
 e l s e   
 	 { 
 	 	 d e f i n e ( " _ P a g e " , " T r a n g " ) ; 
 	 	 d e f i n e ( " _ P r e v " , " T r a n g   s a u " ) ; 
 	 	 d e f i n e ( " _ N e x t " , " T r a n g   t r�� c " ) ; 
 	 } 
 
 c l a s s   c l s P a g e { 
             
 	     v a r   $ t o t a l _ r e c o r d s = 1 ;       / / / T o t a l   R e c o r d s   r e t u r n e d   b y   s q l   q u e r y 
             v a r   $ r e c o r d s _ p e r _ p a g e = 1 ;         / / / h o w   m a n y   r e c o r d s   w o u l d   b e   d i s p l a y e d   a t   a   t i m e 
             v a r   $ p a g e _ n a m e = " " ;   / / / p a g e   n a m e   o n   w h i c h   t h e   c l a s s   i s   c a l l e d 
             v a r   $ s t a r t = 0 ;   
             v a r   $ p a g e = 0 ; 
             v a r   $ t o t a l _ p a g e = 0 ; 
             v a r   $ c u r r e n t _ p a g e ; 
             v a r   $ r e m a i n _ p a g e ; 
             v a r   $ s h o w _ p r e v _ n e x t = t r u e ; 
             v a r   $ s h o w _ s c r o l l _ p r e v _ n e x t = f a l s e ; 
             v a r   $ s h o w _ f i r s t _ l a s t = f a l s e ; 
 	     v a r   $ s h o w _ d i s a b l e d _ l i n k s = t r u e ; 
             v a r   $ s c r o l l _ p a g e = 0 ; 
 	     v a r   $ q r y _ s t r = " " ; 
 	     v a r   $ l i n k _ p a r a = " " ; 
 
 	     / *   r e t u r n s   b o o l e a n   v a l u e   i f   i t   i s   l a s t   p a g e   o r   n o t * / 	 
             f u n c t i o n   i s _ l a s t _ p a g e ( ) 
             { 
               r e t u r n   $ t h i s - > p a g e > = $ t h i s - > t o t a l _ p a g e - 1 ? t r u e : f a l s e ; 
             } 
 	     / *   p a r a m   :   V o i d 
 	 	   r e t u r n s   b o o l e a n   v a l u e   i f   i t   i s   f i r s t   p a g e   o r   n o t * / 	 
             f u n c t i o n   i s _ f i r s t _ p a g e ( ) 
             { 
               r e t u r n   $ t h i s - > p a g e = = 0 ? t r u e : f a l s e ; 
             } 
             f u n c t i o n   c u r r e n t _ p a g e ( ) 
             { 
               r e t u r n   $ t h i s - > p a g e + 1 ; 
             } 
             f u n c t i o n   t o t a l _ p a g e ( ) 
             { 
               r e t u r n   $ t h i s - > t o t a l _ p a g e = = 0 ? 1 : $ t h i s - > t o t a l _ p a g e ; 
             } 
 	     
 	     / / @ p a r a m   :   $ s h o w   =   i f   y o u   w a n t   t o   s h o w   d e s a b l e d   l i n k s   o n   n a v i g a t i o n   l i n k s . 
 	     / / 
 	     f u n c t i o n   s h o w _ d i s a b l e d _ l i n k s ( $ s h o w = T R U E ) 	 
 	     { 
 	     	 $ t h i s - > s h o w _ d i s a b l e d _ l i n k s = $ s h o w ; 
 	     } 
 	     / / @ p a r a m   :   $ l i n k _ p a r a   =   i f   y o u   w a n t   t o   p a s s   a n y   p a r a m e t e r   t o   l i n k 
 	     / / 
 	     f u n c t i o n   s e t _ l i n k _ p a r a m e t e r ( $ l i n k _ p a r a ) 
 	     { 
 	     	 $ t h i s - > l i n k _ p a r a = $ l i n k _ p a r a ; 
 	     } 
             f u n c t i o n   s e t _ p a g e _ n a m e ( $ p a g e _ n a m e ) 
             { 
               $ t h i s - > p a g e _ n a m e = $ p a g e _ n a m e ; 
             } 
 	     / / @ p a r a m   :   s t r =   q u e r y   s t r i n g   y o u   w a n t   t o   p a s s   t o   l i n k s . 
             f u n c t i o n   s e t _ q r y _ s t r i n g ( $ s t r = " " ) 
             { 
               $ t h i s - > q r y _ s t r = " & " . $ s t r ; 
             } 
             f u n c t i o n   s e t _ s c r o l l _ p a g e ( $ s c r o l l _ n u m = 0 ) 
             { 
                 i f ( $ s c r o l l _ n u m ! = 0 ) 
 	 	 	 $ t h i s - > s c r o l l _ p a g e = $ s c r o l l _ n u m ; 
 	 	 e l s e 
 	 	 	 $ t h i s - > s c r o l l _ p a g e = $ t h i s - > t o t a l _ r e c o r d s ; 
 
             } 
             f u n c t i o n   s e t _ t o t a l _ r e c o r d s ( $ t o t a l _ r e c o r d s ) 
             { 
               i f ( $ t o t a l _ r e c o r d s < 0 ) 
                     $ t o t a l _ r e c o r d s = 0 ; 
               $ t h i s - > t o t a l _ r e c o r d s = $ t o t a l _ r e c o r d s ; 
             } 
             f u n c t i o n   s e t _ r e c o r d s _ p e r _ p a g e ( $ r e c o r d s _ p e r _ p a g e ) 
             { 
                   i f ( $ r e c o r d s _ p e r _ p a g e < = 0 ) 
                             $ r e c o r d s _ p e r _ p a g e = $ t h i s - > t o t a l _ r e c o r d s ; 
                   $ t h i s - > r e c o r d s _ p e r _ p a g e = $ r e c o r d s _ p e r _ p a g e ; 
             } 
             / *   @ p a r a m s 
 	     *   	 $ p a g e _ n a m e   =   P a g e   n a m e   o n   w h i c h   c l a s s   i s   i n t e g r a t e d .   i . e .   $ _ S E R V E R [ ' P H P _ S E L F ' ] 
 	     *     	 $ t o t a l _ r e c o r d s = T o t a l   r e c o r d s   r e t u r n d   b y   s q l   q u e r y . 
 	     *   	 $ r e c o r d s _ p e r _ p a g e = H o w   m a n y   p r o j e c t s   w o u l d   b e   d i s p l a y e d   a t   a   t i m e   
 	     * 	 	 $ s c r o l l _ n u m =   H o w   m a n y   p a g e s   s c r o l l e d   i f   w e   c l i c k   o n   s c r o l l   p a g e   l i n k .   
 	     *   	 	 	 	 i . e   i f   w e   w a n t   t o   s c r o l l   6   p a g e s   a t   a   t i m e   t h e n   p a s s   a r g u m e n t   6 . 
 	     *   	 $ s h o w _ p r e v _ n e x t =   b o o l e a n ( t r u e / f a l s e )   t o   s h o w   p r e v   N e x t   L i n k 
 	     *   	 $ s h o w _ s c r o l l _ p r e v _ n e x t =   b o o l e a n ( t r u e / f a l s e )   t o   s h o w   s c r o l l e d   p r e v   N e x t   L i n k 
 	     *   	 $ s h o w _ f i r s t _ l a s t =   b o o l e a n ( t r u e / f a l s e )   t o   s h o w   f i r s t   l a s t   L i n k   t o   m o v e   f i r s t   a n d   l a s t   p a g e . 
 	     * / 
 	     
 	     f u n c t i o n   s e t _ p a g e _ d a t a ( $ p a g e _ n a m e , $ t o t a l _ r e c o r d s , $ r e c o r d s _ p e r _ p a g e = 1 , $ s c r o l l _ n u m = 0 , $ s h o w _ p r e v _ n e x t = t r u e , $ s h o w _ s c r o l l _ p r e v _ n e x t = f a l s e , $ s h o w _ f i r s t _ l a s t = f a l s e ) 
             { 
               $ t h i s - > s e t _ t o t a l _ r e c o r d s ( $ t o t a l _ r e c o r d s ) ; 
               $ t h i s - > s e t _ r e c o r d s _ p e r _ p a g e ( $ r e c o r d s _ p e r _ p a g e ) ; 
               $ t h i s - > s e t _ s c r o l l _ p a g e ( $ s c r o l l _ n u m ) ; 
               $ t h i s - > s e t _ p a g e _ n a m e ( $ p a g e _ n a m e ) ; 
               $ t h i s - > s h o w _ p r e v _ n e x t = $ s h o w _ p r e v _ n e x t ; 
               $ t h i s - > s h o w _ s c r o l l _ p r e v _ n e x t = $ s h o w _ s c r o l l _ p r e v _ n e x t ; 
               $ t h i s - > s h o w _ f i r s t _ l a s t = $ s h o w _ f i r s t _ l a s t ; 
             } 
             / *   @ p a r a m s 
 	     *     $ u s e r _ l i n k =   i f   y o u   w a n t   t o   d i s p l a y   y o u r   l i n k   i . e   i f   y o u   w a n t   t o   u s e r   ' > > '   i n s t e a d   o f   [ f i r s t ]   l i n k   t h e n   u s e 
 	 	   P a g e : : g e t _ f i r s t _ p a g e _ n a v ( " > > " )   O R   f o r   i m a g e 
 	 	   P a g e : : g e t _ f i r s t _ p a g e _ n a v ( " < i m g   s r c = ' '   a l t = ' f i r s t ' > " )   
 	 	   $ l i n k _ p a r a :   l i n k   p a r a m e t e r s   i . e   i f   y o u   w a n t   o t   u s e   a n o t h e r   p a r a m e t e r s   s u c h   a s   c l a s s . 
 	 	   P a g e : : g e t _ f i r s t _ p a g e _ n a v ( " > > " , " c l a s s = m y S t y l e S h e e t C l a s s " ) 
 	     * / 	       
 	     f u n c t i o n   g e t _ f i r s t _ p a g e _ n a v ( $ u s e r _ l i n k = " " , $ l i n k _ p a r a = " " ) 
             { 
 	 	 i f ( $ t h i s - > t o t a l _ p a g e < = 1 ) 
 	 	 	 r e t u r n ; 
 	     	 i f ( t r i m ( $ u s e r _ l i n k ) = = " " ) 
 	 	 	 $ u s e r _ l i n k = '� u ' ; 
                 i f ( ! $ t h i s - > i s _ f i r s t _ p a g e ( ) & &   $ t h i s - > s h o w _ f i r s t _ l a s t ) 
                 { 
 	 	         / / e c h o   '   < a   h r e f = " ' . $ t h i s - > p a g e _ n a m e . ' ? p a g e = 0 ' . $ t h i s - > q r y _ s t r . ' "   ' . $ l i n k _ p a r a . ' > ' . $ u s e r _ l i n k . ' < / a >   ' ; 
                 	 r e t u r n   '   < l i > < a   r e l = " n o f o l l o w "   h r e f = " ' . $ t h i s - > p a g e _ n a m e . ' / t r a n g - 0 ' . $ t h i s - > q r y _ s t r . ' . h t m l "   ' . $ l i n k _ p a r a . ' > ' . $ u s e r _ l i n k . ' < / a >   < / l i > ' ; 
 	 	 } 
 	 	 e l s e i f ( $ t h i s - > s h o w _ f i r s t _ l a s t   & &   $ t h i s - > s h o w _ d i s a b l e d _ l i n k s ) 
                 { 
 	 	 	 / / e c h o   $ u s e r _ l i n k ; 
 	 	 	 r e t u r n   ' < l i > < a   r e l = " n o f o l l o w "   h r e f = " j a v a s c r i p t : v o i d ( 0 ) " > ' . $ u s e r _ l i n k . ' < / a > < / l i > ' ; 
 	 	 } 	 
             } 
             f u n c t i o n   g e t _ l a s t _ p a g e _ n a v ( $ u s e r _ l i n k = " " , $ l i n k _ p a r a = " " ) 
             { 
 	 	 i f ( $ t h i s - > t o t a l _ p a g e < = 1 ) 
 	 	 	 r e t u r n ; 
 	     	 i f ( t r i m ( $ u s e r _ l i n k ) = = " " ) 
 	 	 	 $ u s e r _ l i n k = ' C u� i ' ; 
                 i f ( ! $ t h i s - > i s _ l a s t _ p a g e ( ) & &   $ t h i s - > s h o w _ f i r s t _ l a s t ) 
                 {         
 	 	 	 / / e c h o   '   < a   h r e f = " ' . $ t h i s - > p a g e _ n a m e . ' ? p a g e = ' . ( $ t h i s - > t o t a l _ p a g e - 1 ) . $ t h i s - > q r y _ s t r . ' "   ' . $ l i n k _ p a r a . '   > ' . $ u s e r _ l i n k . ' < / a >   ' ; 
                 	 r e t u r n   '   < l i > < a   r e l = " n o f o l l o w "   h r e f = " ' . $ t h i s - > p a g e _ n a m e . ' / ' . ( $ t h i s - > t o t a l _ p a g e - 1 ) . $ t h i s - > q r y _ s t r . ' . h t m l "   ' . $ l i n k _ p a r a . ' > ' . $ u s e r _ l i n k . ' < / a > < / l i >   ' ; 
 	 	 } 
 	 	 e l s e i f ( $ t h i s - > s h o w _ f i r s t _ l a s t   & &   $ t h i s - > s h o w _ d i s a b l e d _ l i n k s ) 
                 {         
 	 	 	 / / e c h o   $ u s e r _ l i n k ; 
 	 	 	 r e t u r n   ' < l i > < a   r e l = " n o f o l l o w "   h r e f = " j a v a s c r i p t : v o i d ( 0 ) " > ' . $ u s e r _ l i n k . ' < / a > < / l i > ' ; 
 	 	 } 	 
             } 
             f u n c t i o n   g e t _ n e x t _ p a g e _ n a v ( $ u s e r _ l i n k = " " , $ l i n k _ p a r a = " " ) 
             { 
 	 	 i f ( $ t h i s - > t o t a l _ p a g e < = 1 ) 
 	 	 	 r e t u r n ; 
 	     	 i f ( t r i m ( $ u s e r _ l i n k ) = = " " ) 
 	 	 	 $ u s e r _ l i n k = _ P r e v . " & r a q u o ; " ; 
                 i f ( ! $ t h i s - > i s _ l a s t _ p a g e ( ) & &   $ t h i s - > s h o w _ p r e v _ n e x t ) 
 	 	 { 
                         / / e c h o   '   < a   h r e f = " ' . $ t h i s - > p a g e _ n a m e . ' ? p a g e = ' . ( $ t h i s - > p a g e + 1 ) . $ t h i s - > q r y _ s t r . ' "   ' . $ l i n k _ p a r a . ' > ' . $ u s e r _ l i n k . ' < / a >   ' ; 
                 	 r e t u r n   '   < l i > < a   r e l = " n o f o l l o w "   h r e f = " ' . $ t h i s - > p a g e _ n a m e . ' / t r a n g - ' . ( $ t h i s - > p a g e + 1 ) . $ t h i s - > q r y _ s t r . ' . h t m l "   ' . $ l i n k _ p a r a . ' > ' . $ u s e r _ l i n k . ' < / a > < / l i >   ' ; 
 	 	 } 
 	 	 e l s e i f ( $ t h i s - > s h o w _ p r e v _ n e x t   & &   $ t h i s - > s h o w _ d i s a b l e d _ l i n k s ) 
 	 	 { 
                         / / e c h o   $ u s e r _ l i n k ; 
 	 	 	 r e t u r n   ' < l i > < a   r e l = " n o f o l l o w "   h r e f = " j a v a s c r i p t : v o i d ( 0 ) " > ' . $ u s e r _ l i n k . ' < / a > < / l i > ' ; 
 	 	 	 
 	 	 } 	 
             } 
             f u n c t i o n   g e t _ p r e v _ p a g e _ n a v ( $ u s e r _ l i n k = " " , $ l i n k _ p a r a = " " ) 
             { 
 	 	 i f ( $ t h i s - > t o t a l _ p a g e < = 1 ) 
 	 	 	 r e t u r n ; 
 	     	 i f ( t r i m ( $ u s e r _ l i n k ) = = " " ) 
 	 	 	 $ u s e r _ l i n k = " & l a q u o ; " . _ N e x t ; 
                 i f ( ! $ t h i s - > i s _ f i r s t _ p a g e ( ) & &   $ t h i s - > s h o w _ p r e v _ n e x t ) 
                 { 
 	 	         / / e c h o   '   < a   h r e f = " ' . $ t h i s - > p a g e _ n a m e . ' ? p a g e = ' . ( $ t h i s - > p a g e - 1 ) . $ t h i s - > q r y _ s t r . ' "   ' . $ l i n k _ p a r a . ' > ' . $ u s e r _ l i n k . ' < / a >   ' ; 
 	 	 	 r e t u r n   '   < l i > < a   r e l = " n o f o l l o w "   h r e f = " ' . $ t h i s - > p a g e _ n a m e . ' / t r a n g - ' . ( $ t h i s - > p a g e - 1 ) . $ t h i s - > q r y _ s t r . ' . h t m l "   ' . $ l i n k _ p a r a . ' > ' . $ u s e r _ l i n k . ' < / a > < / l i >   ' ; 
 	 	 } 	 
                 e l s e i f ( $ t h i s - > s h o w _ p r e v _ n e x t   & &   $ t h i s - > s h o w _ d i s a b l e d _ l i n k s ) 
 	 	 { 
                         / / e c h o   $ u s e r _ l i n k ; 
 	 	 	 r e t u r n   ' < l i > < a   r e l = " n o f o l l o w "   h r e f = " j a v a s c r i p t : v o i d ( 0 ) " > ' . $ u s e r _ l i n k . ' < / a > < / l i > ' ; 
 	 	 } 	 
             } 
             f u n c t i o n   g e t _ s c r o l l _ p r e v _ p a g e _ n a v ( $ u s e r _ l i n k = " " , $ l i n k _ p a r a = " " ) 
             { 
 	     	 
 	 	 i f ( $ t h i s - > s c r o l l _ p a g e > = $ t h i s - > t o t a l _ p a g e ) 
 	 	 	 r e t u r n ; 
 	 	 i f ( t r i m ( $ u s e r _ l i n k ) = = " " ) 
 	 	 	 $ u s e r _ l i n k = ' < l i > < a   r e l = " n o f o l l o w "   h r e f = " j a v a s c r i p t : v o i d ( 0 ) " > ' . " P r e v [ $ t h i s - > s c r o l l _ p a g e ] " . ' < / a > < / l i > ' ; 
                 i f ( $ t h i s - > p a g e > $ t h i s - > s c r o l l _ p a g e   & & $ t h i s - > s h o w _ s c r o l l _ p r e v _ n e x t ) 
                 {         
 	 	 	 / / e c h o   '   < a   h r e f = " ' . $ t h i s - > p a g e _ n a m e . ' ? p a g e = ' . ( $ t h i s - > p a g e - $ t h i s - > s c r o l l _ p a g e ) . $ t h i s - > q r y _ s t r . ' "   ' . $ l i n k _ p a r a . ' > ' . $ u s e r _ l i n k . ' < / a >   ' ; 
 	 	 	 r e t u r n   '   < l i > < a   r e l = " n o f o l l o w "   h r e f = " ' . $ t h i s - > p a g e _ n a m e . ' / t r a n g - ' . ( $ t h i s - > p a g e - $ t h i s - > s c r o l l _ p a g e ) . $ t h i s - > q r y _ s t r . ' . h t m l "   ' . $ l i n k _ p a r a . ' > ' . $ u s e r _ l i n k . ' < / a > < / l i > ' ; 
 	 	 } 	 
                 e l s e i f ( $ t h i s - > s h o w _ s c r o l l _ p r e v _ n e x t   & &   $ t h i s - > s h o w _ d i s a b l e d _ l i n k s ) 
                 {         
 	 	 	 / / e c h o   $ u s e r _ l i n k ; 
 	 	 	 r e t u r n   $ u s e r _ l i n k ; 
 	 	 } 	 
             } 
             f u n c t i o n   g e t _ s c r o l l _ n e x t _ p a g e _ n a v ( $ u s e r _ l i n k = " " , $ l i n k _ p a r a = " " ) 
             { 
 	 	 i f ( $ t h i s - > s c r o l l _ p a g e > = $ t h i s - > t o t a l _ p a g e ) 
 	 	 	 r e t u r n ; 
 	     	 i f ( t r i m ( $ u s e r _ l i n k ) = = " " ) 
 	 	 	 $ u s e r _ l i n k = ' < l i > < a   r e l = " n o f o l l o w "   h r e f = " j a v a s c r i p t : v o i d ( 0 ) " > ' . " N e x t [ $ t h i s - > s c r o l l _ p a g e ] " . ' < / a > < / l i > ' ; 
                 i f ( $ t h i s - > t o t a l _ p a g e > $ t h i s - > p a g e + $ t h i s - > s c r o l l _ p a g e   & & $ t h i s - > s h o w _ s c r o l l _ p r e v _ n e x t ) 
                 {         
 	 	 	 / / e c h o   '   < a   h r e f = " ' . $ t h i s - > p a g e _ n a m e . ' ? p a g e = ' . ( $ t h i s - > p a g e + $ t h i s - > s c r o l l _ p a g e ) . $ t h i s - > q r y _ s t r . ' "   ' . $ l i n k _ p a r a . ' > ' . $ u s e r _ l i n k . ' < / a >   ' ; 
                 	 r e t u r n   '   < l i > < a   r e l = " n o f o l l o w "   h r e f = " ' . $ t h i s - > p a g e _ n a m e . ' / t r a n g - ' . ( $ t h i s - > p a g e + $ t h i s - > s c r o l l _ p a g e ) . $ t h i s - > q r y _ s t r . ' . h t m l "   ' . $ l i n k _ p a r a . ' > ' . $ u s e r _ l i n k . ' < / a > < / l i >   ' ; 
 	 	 } 
 	 	 e l s e i f ( $ t h i s - > s h o w _ s c r o l l _ p r e v _ n e x t   & &   $ t h i s - > s h o w _ d i s a b l e d _ l i n k s ) 
                 {         
 	 	 	 / / e c h o   $ u s e r _ l i n k ; 
 	 	 	 r e t u r n   $ u s e r _ l i n k ; 
 	 	 	 
 	 	 } 	 
             } 
 
             f u n c t i o n   g e t _ n u m b e r _ p a g e _ n a v ( $ l i n k _ p a r a = " " ) 
             { 
                 $ j = 0 ; 
 	 	 $ s c r o l l _ p a g e = $ t h i s - > s c r o l l _ p a g e ; 
                 i f ( $ t h i s - > p a g e > ( $ s c r o l l _ p a g e / 2 ) ) 
                     $ j = $ t h i s - > p a g e - i n t v a l ( $ s c r o l l _ p a g e / 2 ) ; 
                 i f ( $ j + $ s c r o l l _ p a g e > $ t h i s - > t o t a l _ p a g e ) 
                     $ j = $ t h i s - > t o t a l _ p a g e - $ s c r o l l _ p a g e ; 
 
                 i f ( $ j < 0 ) 
 	 	 	 $ i = 0 ; 
 	 	 e l s e 
 	 	 	 $ i = $ j ; 
 	 	 
 	 	 $ s t r = ' ' ; 
                 f o r ( ; $ i < $ j + $ s c r o l l _ p a g e   & &   $ i < $ t h i s - > t o t a l _ r e c o r d s ; $ i + + ) 
                 { 
 	 	 	   i f ( $ i = = $ t h i s - > p a g e ) 
 	 	 	   {       
 	 	 	 	 / / e c h o   ( $ i + 1 ) ; 
 	 	 	 	 $ s t r . = "   < l i > < a   c l a s s = ' c u r r e n t '   r e l = ' n o f o l l o w '   h r e f = ' j a v a s c r i p t : v o i d ( 0 ) ' > " . ( $ i + 1 ) . " < / a > < / l i > " ; 
 	 	 	 	 
 	 	 	   }   	 
 	 	 	   e l s e 
 	 	 	   {       
 	 	 	 	 
 	 	 	 	 / / e c h o   '   < a   h r e f = " ' . $ t h i s - > p a g e _ n a m e . ' ? p a g e = ' . $ i . $ t h i s - > q r y _ s t r . ' "   ' . $ l i n k _ p a r a . ' > ' . ( $ i + 1 ) . ' < / a >   ' ; 
 	 	 	 	 $ s t r . = '   < l i > < a   r e l = " n o f o l l o w "   h r e f = " ' . $ t h i s - > p a g e _ n a m e . ' / t r a n g - ' . $ i . $ t h i s - > q r y _ s t r . ' . h t m l "   ' . $ l i n k _ p a r a . ' > ' . ( $ i + 1 ) . ' < / a > < / l i >   ' ; 
 	 	 	   }           
 	 	 } 
 	 	 r e t u r n   $ s t r ; 
             } 
 
             f u n c t i o n   g e t _ p a g e _ n a v ( ) 
             { 
 	     	 i f ( $ t h i s - > t o t a l _ r e c o r d s < = 0 ) 
 	 	 { 
 	 	 	 / / e c h o   " N o   R e c o r d s   F o u n d " ; 
 	 	 	 r e t u r n   f a l s e ; 
 	 	 } 
 	 	 e l s e 
 	 	 { 	 
                   $ s t r   =   ' < l i > < s p a n   c l a s s = " p a g i n g _ n a m e " > ' . _ P a g e . ' :   < / s p a n > < / l i > ' ; 
 	 	   $ t h i s - > c a l c u l a t e ( ) ; 
                 / /   $ s t r . = $ t h i s - > g e t _ f i r s t _ p a g e _ n a v ( " " , $ t h i s - > l i n k _ p a r a ) . "   " ; 
                   / / $ s t r . = $ t h i s - > g e t _ s c r o l l _ p r e v _ p a g e _ n a v ( " " , $ t h i s - > l i n k _ p a r a ) . "   " ; 
                   $ s t r . = $ t h i s - > g e t _ p r e v _ p a g e _ n a v ( " " , $ t h i s - > l i n k _ p a r a ) . "   " ; 
                   $ s t r . = $ t h i s - > g e t _ n u m b e r _ p a g e _ n a v ( $ t h i s - > l i n k _ p a r a ) . "   " ; 
                   $ s t r . = $ t h i s - > g e t _ n e x t _ p a g e _ n a v ( " " , $ t h i s - > l i n k _ p a r a ) . "   " ; 
                   / / $ s t r . = $ t h i s - > g e t _ s c r o l l _ n e x t _ p a g e _ n a v ( " " , $ t h i s - > l i n k _ p a r a ) . "   " ; 
                 / /   $ s t r . = $ t h i s - > g e t _ l a s t _ p a g e _ n a v ( " " , $ t h i s - > l i n k _ p a r a ) . "   " ; 
 	 	   
 	 	   r e t u r n   $ s t r ; 
 	 	   
 	 	   } 
             } 
             f u n c t i o n   c a l c u l a t e ( ) 
             { 
                 $ t h i s - > p a g e = i n t v a l ( $ _ R E Q U E S T [ ' p a g e ' ] ) ; 
                 i f ( ! i s _ n u m e r i c ( $ t h i s - > p a g e ) ) 
                     $ t h i s - > p a g e = 0 ; 
                 $ t h i s - > s t a r t = $ t h i s - > p a g e * $ t h i s - > r e c o r d s _ p e r _ p a g e ; 
                 $ t h i s - > t o t a l _ p a g e = @ i n t v a l ( $ t h i s - > t o t a l _ r e c o r d s / $ t h i s - > r e c o r d s _ p e r _ p a g e ) ; 
                 i f ( $ t h i s - > t o t a l _ r e c o r d s % $ t h i s - > r e c o r d s _ p e r _ p a g e ! = 0 ) 
                     $ t h i s - > t o t a l _ p a g e + + ; 
             } 
             f u n c t i o n   g e t _ l i m i t _ q u e r y ( $ q r y = " " ) 
             { 
                 $ t h i s - > c a l c u l a t e ( ) ; 
                 r e t u r n   $ q r y . "   L I M I T   $ t h i s - > s t a r t , $ t h i s - > r e c o r d s _ p e r _ p a g e " ; 
             } 	     
 } 
           
           
           / *   E x a m p l e   1 
                 $ p a g e = n e w   P a g e ( ) ; 
                 $ p a g e - > s e t _ t o t a l _ r e c o r d s ( $ t o t a l _ r e c o r d s ) ;   / / n u m b e r   o f   T o t a l   r e c o r d s 
                 $ p a g e - > s e t _ r e c o r d s _ p e r _ p a g e ( 1 ) ;   / / n u m b e r   o f   r e c o r d s   d i s p l a y s   o n   a   s i n g l e   p a g e 
                 / / $ p a g e - > s h o w _ p r e v _ n e x t = f a l s e ;   / / S h o w s   P r e v i o u s   a n d   N e x t   P a g e   l i n k s 
                 $ p a g e - > s h o w _ s c r o l l _ p r e v _ n e x t = t r u e ;   / / S h o w s   P r e v i o u s   a n d   N e x t   P a g e   l i n k s 
                 $ p a g e - > s h o w _ f i r s t _ l a s t = t r u e ;   / / S h o w s   f i r s t   a n d   L a s t   P a g e   l i n k s 
                 $ p a g e - > s e t _ p a g e _ n a m e ( ' d s a y s 2 . p h p ' ) ;   / / s e t   t h e   p a g e   n a m e   o n   w h i c h   p a g i n g   h a s   t o   b e   d o e n 
 
                 e c h o   $ q r y = $ p a g e - > g e t _ l i m i t _ q u e r y ( $ q r y ) ;   / / r e t u r n   t h e   q u e r y   w i t h   l i m i t s 
                 e c h o   " < b r > " ; 
                 $ d b - > q u e r y ( $ q r y ) ; 
                 w h i l e ( $ r o w = $ d b - > f e t c h O b j e c t ( ) ) 
                 { 
                 e c h o   $ r o w - > u s e r n a m e . " < b r > " ; 
                 } 
                 $ p a g e - > g e t _ p a g e _ n a v ( ) ;   / /   S h o w s   t h e   n e v i g a t i o n   b a r s ; 
           * / 
           
           / *   E x a m p l e   2 
               $ p a g e = n e w   P a g e ( ) ; 
 	 	 
 
               $ p a g e - > s e t _ p a g e _ d a t a ( ' d s a y s 2 . p h p ' , $ t o t a l _ r e c o r d s , 7 , 0 , f a l s e , f a l s e , t r u e ) ; 
 
           * / 
 ? > 
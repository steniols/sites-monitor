@csrf()
<input type="text" name="endpoint" placeholder="Endpoint" value={{ $endpoint->endpoint ?? old('endpoint') }}>
<input type="text" name="frequency" placeholder="Frequência" value={{ $endpoint->frequency ?? old('frequency') }}>
<button type="submit">Enviar</button>
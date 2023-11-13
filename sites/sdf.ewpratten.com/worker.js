export default {
    async fetch(request, env, ctx) {
      if (request.url) {
        // Construct the destination URL
        let sdf_url = new URL("http://ewpratten.sdf.org");
        sdf_url.pathname = (new URL(request.url)).pathname;
  
        // Forward CF info if it exists
        let headers = {};
        if (request.cf) {
          headers["X-CF-ASN"] = request.cf.asn;
          headers["X-CF-As-Organization"] = request.cf.asOrganization;
          headers["X-CF-Colo"] = request.cf.colo;
          headers["X-CF-Country"] = request.cf.country;
          headers["X-CF-Timezone"] = request.cf.timezone;
        }
  
        // Build a request
        let sdf_request = new Request(
          sdf_url,
          {
            headers: headers
          }
        );
  
        // Fetch the content from SDF
        let response = await fetch(sdf_request);
        return response;
      }
    },
  };